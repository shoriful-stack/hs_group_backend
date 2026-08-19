<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\NewsEventDataTable;
use App\Enums\Status;
use App\Http\Requests\Blog\NewsEventRequest;
use App\Models\NewsEvent;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class NewsEventController extends Controller
{
    public function index(NewsEventDataTable $dataTable)
    {
        return $dataTable->render('newsEvent.index');
    }

    public function create()
    {
        return view('newsEvent.create');
    }

    public function store(NewsEventRequest $request)
    {
        try {
            DB::beginTransaction();

            $image = null;
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload($request->file('image'), uniqid(), 'news/events');
            }

            NewsEvent::create([
                'language_id' => 1,
                'title'       => $request->title,
                'event_date'  => $request->event_date,
                'location'    => $request->location,
                'image'       => $image,
                'cta_label'   => $request->cta_label,
                'cta_href'    => $request->cta_href,
                'serial_no'   => $request->serial_no,
                'status'      => Status::ACTIVE,
            ]);

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(NewsEvent $newsEvent)
    {
        return view('newsEvent.edit', compact('newsEvent'));
    }

    public function update(NewsEventRequest $request, NewsEvent $newsEvent)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $newsEvent->image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'news/events',
                    $newsEvent->image
                );
            }

            $newsEvent->update([
                'title'      => $request->title,
                'event_date' => $request->event_date,
                'location'   => $request->location,
                'image'      => $newsEvent->image,
                'cta_label'  => $request->cta_label,
                'cta_href'   => $request->cta_href,
                'serial_no'  => $request->serial_no,
                'status'     => $request->status,
            ]);

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(NewsEvent $newsEvent)
    {
        try {
            $newsEvent->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
