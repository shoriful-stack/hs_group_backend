<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\ProjectEquipmentCategoryDataTable;
use App\Models\ProjectEquipmentCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectEquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectEquipmentCategoryDataTable $projectEquipmentCategoryDataTable)
    {
        return $projectEquipmentCategoryDataTable->render('projectEquipmentCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projectEquipmentCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:project_equipment_categories,name',
            ])->validate();

            ProjectEquipmentCategory::create([
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
    public function show(ProjectEquipmentCategory $projectEquipmentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectEquipmentCategory $projectEquipmentCategory)
    {
        return view('projectEquipmentCategory.edit', compact('projectEquipmentCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectEquipmentCategory $projectEquipmentCategory)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:project_equipment_categories,name,' . $projectEquipmentCategory->id,
            ])->validate();

            $projectEquipmentCategory->update([
                'name'        => $request->name,
            ]);

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
    public function destroy(ProjectEquipmentCategory $projectEquipmentCategory)
    {
        try {
            $projectEquipmentCategory->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
