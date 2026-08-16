<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProjectController
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $limit = (int) $request->get('limit', 10);
        $page = (int) $request->get('page', 1);

        // $cacheKey = $category ? "projects_category_{$category}" : "projects_all";
        $version = Cache::get('projects_cache_version', 1);

        $cacheKey = "projects_v{$version}_" . ($category ?? 'all') . "_p{$page}_l{$limit}";

        $projects = Cache::remember($cacheKey, 86400, function () use ($category, $limit) {
            $query = DB::table('projects')
                ->leftJoin('project_categories', 'project_categories.id', '=', 'projects.category_id')
                ->leftJoin('our_customers', 'our_customers.id', '=', 'projects.our_customer_id')
                ->select(
                    'projects.id',
                    'projects.category_id',
                    'projects.title',
                    'projects.slug',
                    'projects.image',
                    'projects.location',
                    'projects.year',
                    'projects.description',
                    'projects.project_value',
                    'our_customers.title as customer_name',
                    'project_categories.name as cat_name',
                    'project_categories.slug as cat_slug'
                )
                ->when($category, function ($query, $category) {
                    return $query->where('project_categories.slug', $category);
                })
                ->orderByDesc('id');

            return $query->paginate($limit);
            // return $data->map(function ($item) {
            //     return [
            //         'id' => $item->id,
            //         'title' => $item->title,
            //         'slug' => $item->slug,
            //         'image' => $item->image,
            //         'location' => $item->location,
            //         'year' => $item->year,
            //         'category' => [
            //             'name' => $item->cat_name,
            //             'slug' => $item->cat_slug,
            //         ]
            //     ];
            // });
        });

        return response()->json([
            'success' => true,
            'data' => collect($projects->items())->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category_id' => $item->category_id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'image' => $item->image,
                    'location' => $item->location,
                    'description' => $item->description,
                    'project_value' => $item->project_value,
                    'year' => $item->year,
                    'customer_name' => $item->customer_name,
                    'category' => [
                        'name' => $item->cat_name,
                        'slug' => $item->cat_slug,
                    ]
                ];
            }),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total(),
            ]
        ]);
    }
    public function show($slug)
    {
        $cacheKey = "project_detail_{$slug}";

        $project = Cache::remember($cacheKey, 86400, function () use ($slug) {
            return Project::query()
                ->where('slug', $slug)
                ->select(
                    'id',
                    'category_id',
                    'our_customer_id',
                    'location',
                    'year',
                    'title',
                    'slug',
                    'duration',
                    'project_value',
                    'description',
                    'image',
                    'seo_title',
                    'seo_description',
                    'seo_keywords'
                )
                ->with([
                    'category:id,name,slug',
                    'customer:id,title',
                    // 'highlights:id,project_id,title,value',
                    'informations:id,project_id,icon,title,description',
                    'scopes:id,project_id,step_number,title,description',
                    'problemsolvings:id,project_id,challenge,solution',
                    'equipments' => function ($query) {
                        $query->select('id', 'project_id', 'project_equipment_category_id', 'name', 'icon')
                            ->with('category:id,name');
                    },
                    'impacts:id,project_id,title,value',
                    'reviews:id,project_id,designation,department,description',
                    'galleries:id,project_id,image',
                    'ctas:id,ctaable_id,ctaable_type,question,answer'
                ])
                ->first();
        });

        if (!$project) {
            return response()->json(['success' => false, 'message' => 'Project Not Found!'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project
        ], 200);
    }
    public function category()
    {
        $project_categories = Cache::remember('project_categories', 86400, function () {
            return DB::table('project_categories')
                ->select(
                    'id',
                    'name',
                    'slug'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => $project_categories
        ], 200);
    }
}
