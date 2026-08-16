<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\BrandDataTable;
use App\Enums\Status;
use App\Models\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $brandDataTable)
    {
        return $brandDataTable->render('brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'title'    => 'required|string|unique:brands,title',
                'image'   => 'required|max:1024|mimes:png,jpeg,jpg',
                'contents' => 'nullable|string',
                'domain'  => 'nullable|string',
            ])->validate();

            $image = '';
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    'brand_' . uniqid(),
                    'brand',
                );
            }

            $brand = new Brand();
            $brand->title = $request->title;
            $brand->image = $image;
            $brand->content = $request->contents;
            $brand->domain = $request->domain;
            $brand->save();

            Cache::forget('brands');
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
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'title'    => 'required|string|unique:brands,title,' . $brand->id,
                'image'   => 'nullable|max:1024|mimes:png,jpeg,jpg',
                'content' => 'nullable|string',
                'domain'           => 'nullable|string|unique:brands,domain,' . $brand->id,
                'status'  => new Enum(Status::class),
            ])->validate();

            $image = $brand->image;
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    'brand_' . uniqid(),
                    'brand',
                    $brand->image
                );
            }

            $brand->title = $request->title;
            $brand->image = $image;
            $brand->content = $request->content;
            $brand->domain = $request->domain;
            $brand->status = $request->status;
            $brand->save();

            Cache::forget('brands');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            Cache::forget('brands');
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
