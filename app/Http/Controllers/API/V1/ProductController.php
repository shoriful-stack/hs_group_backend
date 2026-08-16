<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $limit = (int) $request->get('limit', 12);
        $page = (int) $request->get('page', 1);

        // $cacheKey = $category ? "products_category_{$category}" : "products_all";
        $version = Cache::get('products_cache_version', 1);

        $cacheKey = "products_v{$version}_" . ($category ?? 'all') . "_p{$page}_l{$limit}";

        $products = Cache::remember($cacheKey, 86400, function () use ($category, $limit) {
            $query = DB::table('products')
                ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id')
                ->select(
                    'products.id',
                    'products.category_id',
                    'products.title',
                    'products.slug',
                    'products.image',
                    'products.subtitle',
                    'product_categories.name as cat_name',
                    'product_categories.slug as cat_slug'
                )
                ->when($category, function ($query, $category) {
                    return $query->where('product_categories.slug', $category);
                });

            return $query->paginate($limit);
        });

        return response()->json([
            'success' => true,
            'data' => collect($products->items())->map(function ($item) {
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
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }
    public function show($slug)
    {
        $cacheKey = "product_detail_{$slug}";
        $product = Cache::remember($cacheKey, 86400, function () use ($slug) {
            return Product::query()
                ->where('slug', $slug)
                ->select(
                    'id',
                    'category_id',
                    'title',
                    'slug',
                    'subtitle',
                    'description',
                    'technical_specifications',
                    'image',
                    'seo_title',
                    'seo_description',
                    'seo_keywords'
                )
                ->with(
                    'category:id,name,slug',
                    'galleries:id,product_id,image',
                    'applications:id,product_id,title',
                    'overviews:id,product_id,title',
                    'features:id,product_id,title',
                    'documents:id,product_id,title,attachment,link,description,type'
                )
                ->first();
        });

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }
    public function category()
    {
        $product_categories = Cache::remember('product_categories', 86400, function () {
            return DB::table('product_categories')
                ->select(
                    'id',
                    'name',
                    'slug'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => $product_categories
        ], 200);
    }
}
