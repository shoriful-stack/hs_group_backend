<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceDataTable;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceEquipment;
use App\Models\ServiceEquipmentCategory;
use App\Services\ServicesService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceDataTable $serviceDataTable)
    {
        return $serviceDataTable->render('service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ServiceCategory::where('status', 1)->pluck('id', 'name');
        $equipmentCategories = ServiceEquipmentCategory::pluck('id', 'name');
        return view('service.create', compact('categories', 'equipmentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request, ServicesService $servicesService)
    {
        try {
            DB::beginTransaction();

            $servicesService->createOrUpdate($request);

            DB::commit();

            return redirect()->route('services.index')
                ->with('success', 'Service created successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::where('status', 1)->pluck('id', 'name');
        $equipmentCategories = ServiceEquipmentCategory::pluck('id', 'name');
        $equipmentGroups = ServiceEquipment::where('service_id', $service->id)
            ->get()
            ->groupBy('service_equipment_category_id');
        return view('service.create', compact('service', 'categories', 'equipmentCategories', 'equipmentGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service, ServicesService $servicesService)
    {
        try {
            DB::beginTransaction();

            // Update Service
            $servicesService->createOrUpdate($request, $service->id);

            DB::commit();

            return redirect()->route('services.index')
                ->with('success', 'Service updated successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
