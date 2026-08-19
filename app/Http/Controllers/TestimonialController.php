<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\TestimonialDataTable;
use App\Enums\Status;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    public function index(TestimonialDataTable $dataTable)
    {
        return $dataTable->render('testimonial.index');
    }

    public function create()
    {
        return view('testimonial.create');
    }

    public function store(TestimonialRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'testimonial'
                );
            }

            $testimonial = new Testimonial();
            $testimonial->language_id = $request->language_id ?? 1;
            $testimonial->name = $request->name ?? '';
            $testimonial->role = $request->role ?? '';
            $testimonial->quote = $request->quote ?? '';
            $testimonial->image = $image ?? null;
            $testimonial->status = Status::ACTIVE;
            $testimonial->save();

            Cache::forget('testimonials');
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('testimonial.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        try {
            DB::beginTransaction();

            $image = $testimonial->image;

            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'testimonial',
                    $testimonial->image
                );
            }

            $testimonial->language_id = $request->language_id ?? 1;
            $testimonial->name = $request->name ?? '';
            $testimonial->role = $request->role ?? '';
            $testimonial->quote = $request->quote ?? '';
            $testimonial->image = $image;
            $testimonial->status = $request->status ?? $testimonial->status;
            $testimonial->save();

            Cache::forget('testimonials');
            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            $testimonial->delete();
            Cache::forget('testimonials');
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
