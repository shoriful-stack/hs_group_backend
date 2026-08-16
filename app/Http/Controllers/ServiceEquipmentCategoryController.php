<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\ServiceEquipmentCategoryDataTable;
use App\Models\ServiceEquipmentCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceEquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceEquipmentCategoryDataTable $serviceEquipmentCategoryDataTable)
    {
        return $serviceEquipmentCategoryDataTable->render('serviceEquipmentCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('serviceEquipmentCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:service_equipment_categories,name',
            ])->validate();

            ServiceEquipmentCategory::create([
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
    public function show(ServiceEquipmentCategory $serviceEquipmentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceEquipmentCategory $serviceEquipmentCategory)
    {
        return view('serviceEquipmentCategory.edit', compact('serviceEquipmentCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceEquipmentCategory $serviceEquipmentCategory)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:service_equipment_categories,name,' . $serviceEquipmentCategory->id,
            ])->validate();

            $serviceEquipmentCategory->update([
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
    public function destroy(ServiceEquipmentCategory $serviceEquipmentCategory)
    {
        try {
            $serviceEquipmentCategory->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
