<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ServiceController
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $limit = (int) $request->get('limit', 10);
        $page = (int) $request->get('page', 1);

        // $cacheKey = $category ? "services_category_{$category}" : "services_all";

        $version = Cache::get('services_cache_version', 1);

        $cacheKey = "services_v{$version}_" . ($category ?? 'all') . "_p{$page}_l{$limit}";

        $services = Cache::remember($cacheKey, 86400, function () use ($category, $limit) {
            $query = DB::table('services')
                ->leftJoin('service_categories', 'service_categories.id', '=', 'services.category_id')
                ->select(
                    'services.id',
                    'services.category_id',
                    'services.title',
                    'services.slug',
                    'services.image',
                    'services.subtitle',
                    'service_categories.name as cat_name',
                    'service_categories.slug as cat_slug'
                )
                ->when($category, function ($query, $category) {
                    return $query->where('service_categories.slug', $category);
                });

            return $query->paginate($limit);
        });

        return response()->json([
            'success' => true,
            'data' => collect($services->items())->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category_id' => $item->category_id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'image' => $item->image,
                    'subtitle' => $item->subtitle,
                    'category' => [
                        'name' => $item->cat_name,
                        'slug' => $item->cat_slug,
                    ]
                ];
            }),
            'meta' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
            ]
        ]);
    }
    public function show($slug)
    {
        $cacheKey = "service_detail_{$slug}";

        $service = Cache::remember($cacheKey, 86400, function () use ($slug) {
            return Service::query()
                ->where('slug', $slug)
                ->select(
                    'id',
                    'category_id',
                    'title',
                    'slug',
                    'subtitle',
                    'description',
                    'image',
                    'seo_title',
                    'seo_description',
                    'seo_keywords'
                )
                ->with([
                    'category:id,name,slug',
                    'highlights:id,service_id,title,value',
                    'benefits:id,service_id,icon,title,description',
                    'capabilities:id,service_id,title,description',
                    'scopes:id,service_id,step_number,title,description',
                    'processSteps:id,service_id,serial_no,title,description',
                    // Equipment ebong tar category handle kora
                    'equipments' => function ($query) {
                        $query->select('id', 'service_id', 'service_equipment_category_id', 'name', 'icon')
                            ->with('category:id,name');
                    },
                    'ctas:id,ctaable_id,ctaable_type,question,answer'
                ])
                ->first();
        });

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }
    public function category()
    {
        $service_categories = Cache::remember('service_categories', 86400, function () {
            return DB::table('service_categories')
                ->select(
                    'id',
                    'name',
                    'slug'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => $service_categories
        ], 200);
    }
}
