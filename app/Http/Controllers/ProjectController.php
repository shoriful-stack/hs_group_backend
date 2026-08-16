<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectDataTable;
use App\Http\Requests\ProjectRequest;
use App\Models\Cta;
use App\Models\OurCustomer;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectEquipment;
use App\Models\ProjectEquipmentCategory;
use App\Models\ProjectProblemSolving;
use App\Services\ProjectService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectDataTable $projectDataTable)
    {
        return $projectDataTable->render('project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProjectCategory::where('status', 1)->pluck('id', 'name');
        $customers = OurCustomer::where('status', 1)->pluck('id', 'title');
        $equipmentCategories = ProjectEquipmentCategory::pluck('id', 'name');
        return view('project.create', compact('categories', 'customers', 'equipmentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request, ProjectService $projectService)
    {
        try {
            DB::beginTransaction();

            $projectService->createOrUpdate($request);

            DB::commit();

            return redirect()->route('projects.index')
                ->with('success', 'Project created successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $categories = ProjectCategory::where('status', 1)->pluck('id', 'name');
        $customers = OurCustomer::where('status', 1)->pluck('id', 'title');
        $equipmentCategories = ProjectEquipmentCategory::pluck('id', 'name');
        $equipmentGroups = ProjectEquipment::where('project_id', $project->id)
            ->get()
            ->groupBy('project_equipment_category_id');
        return view('project.create', compact('project', 'categories', 'customers', 'equipmentCategories', 'equipmentGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, ProjectService $projectService)
    {
        try {
            DB::beginTransaction();

            // Update Project
            $projectService->createOrUpdate($request, $project->id);

            DB::commit();

            return redirect()->route('projects.index')
                ->with('success', 'Project updated successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
