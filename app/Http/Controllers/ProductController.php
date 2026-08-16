<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ProductService;
use App\Services\SearchService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new ProductService();
    }
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('product.index');
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 1)->pluck('id', 'name');
        return view('product.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create Product
            $this->service->createOrUpdate($request);

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('status', 1)->pluck('id', 'name');
        return view('product.create', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // Update Product
            $this->service->createOrUpdate($request, $product->id);

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->thumb_image && file_exists(public_path($product->thumb_image))) {
                @unlink(public_path($product->thumb_image));
            }
            if ($product->background_image && file_exists(public_path($product->background_image))) {
                @unlink(public_path($product->background_image));
            }

            foreach ($product->productFeatures as $feature) {
                if ($feature->image && file_exists(public_path($feature->image))) {
                    @unlink(public_path($feature->image));
                }
                $feature->delete();
            }

            foreach ($product->productVideos as $video) {
                if ($video->image && file_exists(public_path($video->image))) {
                    @unlink(public_path($video->image));
                }
                $video->delete();
            }

            foreach ($product->productDocuments as $doc) {
                if ($doc->attachment && file_exists(public_path($doc->attachment))) {
                    @unlink(public_path($doc->attachment));
                }
                $doc->delete();
            }

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $results = (new SearchService)->search(Product::class, $request);
        return response()->json($results);
    }
}
