<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\ProjectCategoryDataTable;
use App\Enums\Status;
use App\Models\ProjectCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectCategoryDataTable $projectCategoryDataTable)
    {
        return $projectCategoryDataTable->render('projectCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projectCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:project_categories,name',
            ])->validate();

            ProjectCategory::create([
                'name'        => $request->name,
            ]);

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
    public function show(ProjectCategory $projectCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        return view('projectCategory.edit', compact('projectCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectCategory $projectCategory)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:project_categories,name,' . $projectCategory->id,
                'status'  => new Enum(Status::class),
            ])->validate();

            $projectCategory->update([
                'name'        => $request->name,
                'status'      => $request->status,
            ]);

            Cache::forget('project_categories');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        try {
            $projectCategory->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
