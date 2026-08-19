<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\MilestoneDataTable;
use App\Enums\Status;
use App\Models\Milestone;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class MilestoneController extends Controller
{
    public function index(MilestoneDataTable $milestoneDataTable)
    {
        return $milestoneDataTable->render('milestone.index');
    }

    public function create()
    {
        return view('milestone.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'title'    => 'required|string|unique:milestones,title',
                'contents' => 'required|string',
                'year'     => 'required|string',
                'serial_no'=> 'required|numeric',
                'image'    => 'nullable|file|mimes:jpeg,jpg,png,webp|max:4096',
            ])->validate();

            $image = null;
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload($request->file('image'), uniqid(), 'milestone');
            }

            $milestone = new Milestone();
            $milestone->title = $request->title;
            $milestone->year = $request->year;
            $milestone->serial_no = $request->serial_no;
            $milestone->content = $request->contents;
            $milestone->image = $image;
            $milestone->save();
            Cache::forget('milestones');
            Cache::forget('milestones_v2');

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    public function edit(Milestone $milestone)
    {
        return view('milestone.edit', compact('milestone'));
    }

    public function update(Request $request, Milestone $milestone)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'title'     => 'nullable|string|unique:milestones,title,' . $milestone->id,
                'contents'  => 'nullable|string',
                'year'      => 'nullable|string',
                'serial_no' => 'nullable|numeric',
                'image'     => 'nullable|file|mimes:jpeg,jpg,png,webp|max:4096',
                'status'    => new Enum(Status::class),
            ])->validate();

            $image = $milestone->image;
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'milestone',
                    $milestone->image
                );
            }

            $milestone->title = $request->title;
            $milestone->year = $request->year;
            $milestone->serial_no = $request->serial_no;
            $milestone->content = $request->contents;
            $milestone->image = $image;
            $milestone->status = $request->status;
            $milestone->save();

            Cache::forget('milestones');
            Cache::forget('milestones_v2');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    public function destroy(Milestone $milestone)
    {
        try {
            $milestone->delete();
            Cache::forget('milestones');
            Cache::forget('milestones_v2');

            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
