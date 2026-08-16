<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\ServiceCategoryDataTable;
use App\Enums\Status;
use App\Models\ServiceCategory;
use App\Services\SearchService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceCategoryDataTable $serviceCategoryDataTable)
    {
        return $serviceCategoryDataTable->render('serviceCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('serviceCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:service_categories,name',
            ])->validate();

            ServiceCategory::create([
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
    public function show(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        return view('serviceCategory.edit', compact('serviceCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:service_categories,name,' . $serviceCategory->id,
                'status'  => new Enum(Status::class),
            ])->validate();

            $serviceCategory->update([
                'name'        => $request->name,
                'status'      => $request->status,
            ]);

            Cache::forget('service_categories');

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
    public function destroy(ServiceCategory $serviceCategory)
    {
        try {
            $serviceCategory->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
    public function search(Request $request)
    {
        $results = (new SearchService)->search(ServiceCategory::class, $request, ['id', 'name']);
        $results = collect($results)->values();
        return response()->json($results);
    }
}
