<?php

namespace App\Http\Controllers;

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
    /**
     * Display a listing of the resource.
     */
    public function index(MilestoneDataTable $milestoneDataTable)
    {
        return $milestoneDataTable->render('milestone.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('milestone.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'title'    => 'required|string|unique:milestones,title',
                'contents' => 'required|string',
                'year'  => 'required|string',
                'serial_no'  => 'required|numeric',
            ])->validate();

            $brand = new Milestone();
            $brand->title = $request->title;
            $brand->year = $request->year;
            $brand->serial_no = $request->serial_no;
            $brand->content = $request->contents;
            $brand->save();
            Cache::forget('milestones');

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Milestone $milestone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Milestone $milestone)
    {
        return view('milestone.edit', compact('milestone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Milestone $milestone)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'title'    => 'nullable|string|unique:brands,title,' . $milestone->id,
                'contents' => 'nullable|string',
                'year'  => 'nullable|string',
                'serial_no'  => 'nullable|numeric',
                'status'  => new Enum(Status::class),
            ])->validate();

            $milestone->title = $request->title;
            $milestone->year = $request->year;
            $milestone->serial_no = $request->serial_no;
            $milestone->content = $request->contents;
            $milestone->status = $request->status;
            $milestone->save();

            Cache::forget('milestones');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Milestone $milestone)
    {
        try {
            $milestone->delete();
            Cache::forget('milestones');

            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
