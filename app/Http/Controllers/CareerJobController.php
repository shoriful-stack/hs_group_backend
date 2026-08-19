<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\CareerJobDataTable;
use App\Enums\Status;
use App\Http\Requests\CareerJobRequest;
use App\Models\CareerJob;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CareerJobController extends Controller
{
    public function index(CareerJobDataTable $dataTable)
    {
        return $dataTable->render('careerJob.index');
    }

    public function create()
    {
        return view('careerJob.create');
    }

    public function store(CareerJobRequest $request)
    {
        try {
            DB::beginTransaction();

            $image = null;
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload($request->file('image'), uniqid(), 'careers');
            }

            CareerJob::create([
                'title'                      => $request->title,
                'department'                 => $request->department,
                'location'                   => $request->location,
                'type'                       => $request->type,
                'experience'                 => $request->experience,
                'posted_at'                  => $request->posted_at,
                'application_deadline'       => $request->application_deadline,
                'vacancy'                    => $request->vacancy,
                'summary'                    => $request->summary,
                'overview'                   => $request->overview,
                'educational_qualifications' => $this->lines($request->educational_qualifications),
                'experience_details'         => $this->lines($request->experience_details),
                'responsibilities'           => $this->lines($request->responsibilities),
                'requirements'               => $this->lines($request->requirements),
                'nice_to_have'               => $this->lines($request->nice_to_have),
                'benefits'                   => $this->lines($request->benefits),
                'apply_email'                => $request->apply_email,
                'contact_phones'             => $this->lines($request->contact_phones),
                'application_instruction'    => $request->application_instruction,
                'image'                      => $image,
                'featured'                   => $request->boolean('featured'),
                'serial_no'                  => $request->serial_no,
                'status'                     => Status::ACTIVE,
            ]);

            $this->forgetCareerCache();
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(CareerJob $careerJob)
    {
        return view('careerJob.edit', compact('careerJob'));
    }

    public function update(CareerJobRequest $request, CareerJob $careerJob)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $careerJob->image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'careers',
                    $careerJob->image
                );
            }

            $careerJob->update([
                'title'                      => $request->title,
                'department'                 => $request->department,
                'location'                   => $request->location,
                'type'                       => $request->type,
                'experience'                 => $request->experience,
                'posted_at'                  => $request->posted_at,
                'application_deadline'       => $request->application_deadline,
                'vacancy'                    => $request->vacancy,
                'summary'                    => $request->summary,
                'overview'                   => $request->overview,
                'educational_qualifications' => $this->lines($request->educational_qualifications),
                'experience_details'         => $this->lines($request->experience_details),
                'responsibilities'           => $this->lines($request->responsibilities),
                'requirements'               => $this->lines($request->requirements),
                'nice_to_have'               => $this->lines($request->nice_to_have),
                'benefits'                   => $this->lines($request->benefits),
                'apply_email'                => $request->apply_email,
                'contact_phones'             => $this->lines($request->contact_phones),
                'application_instruction'    => $request->application_instruction,
                'image'                      => $careerJob->image,
                'featured'                   => $request->boolean('featured'),
                'serial_no'                  => $request->serial_no,
                'status'                     => $request->status ?? $careerJob->status,
            ]);

            $this->forgetCareerCache();
            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(CareerJob $careerJob)
    {
        $careerJob->delete();
        $this->forgetCareerCache();
        return ReturnMessage::deleteSuccess();
    }

    private function lines(?string $value): array
    {
        if (!$value) {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }

    private function forgetCareerCache(): void
    {
        Cache::forget('career_jobs');
    }
}
