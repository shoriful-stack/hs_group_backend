<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends BaseController {
    public function index() {

        $productCategories = ProductCategory::with( 'language', 'branch', 'children' )
        ->whereNull('parent_id')
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'productCategories' => ProductCategoryResource::collection( $productCategories ),
        ];
        return $this->sendResponse( $array, 'Product Categories retrieved successfully.' );
    }

    private function getAllCategoryIds($category)
    {
        $ids = [$category->id];

        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getAllCategoryIds($child));
        }

        return $ids;
    }


    public function show( Request $request, $slug ) {
        $category = ProductCategory::with('childrenRecursive')->where('slug', $slug)->first();

        if ( !$category ) {
            return $this->sendError( 'Category not found' );
        }

        $allCategoryIds = $this->getAllCategoryIds($category);

        $products = Product::query()
            ->with( ['productCategory', 'productBrand', 'productOrigin'] )
            ->where('branch_id', getBranchByDomain()->id)
            ->whereIn( 'category_id', $allCategoryIds );

        if ( $request->has( 'brand' ) ) {
            $products->whereHas( 'productBrand', function ( $q ) use ( $request ) {
                $q->where( 'slug', $request->brand );
            } );
        }

        if ( $request->has( 'origin' ) ) {
            $products->whereHas( 'productOrigin', function ( $q ) use ( $request ) {
                $q->where( 'slug', $request->origin );
            } );
        }

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $products->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $perPage = $request->get( 'per_page', 10 );
        $paginated = $products->paginate( $perPage );

        return $this->sendResponse( [
            'category'     => new ProductCategoryResource( $category ),
            'products'     => ProductResource::collection( $paginated ),
            'totalResults' => $paginated->total(),
            'currentPage'  => $paginated->currentPage(),
            'totalPages'   => $paginated->lastPage(),
        ], 'Product retrieved successfully' );
    }
}
