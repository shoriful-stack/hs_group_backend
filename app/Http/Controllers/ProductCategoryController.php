<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\ProductCategoriesDataTable;
use App\Enums\Status;
use App\Models\ProductCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductCategoriesDataTable $productCategoriesDataTable)
    {
        return $productCategoriesDataTable->render('productCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:product_categories,name',
            ])->validate();

            ProductCategory::create([
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
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('productCategory.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:product_categories,name,' . $productCategory->id,
                'status'  => new Enum(Status::class),
            ])->validate();

            $productCategory->update([
                'name'        => $request->name,
                'status'      => $request->status,
            ]);

            Cache::forget('product_categories');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
