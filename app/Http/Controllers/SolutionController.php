<?php

namespace App\Http\Controllers;

use App\DataTables\SolutionDataTable;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolutionController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }
    public function index(SolutionDataTable $dataTable)
    {
        return $dataTable->render('solution.index');
    }

    public function create()
    {
        return view('solution.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create Product
            $this->service->createOrUpdate($request);

            DB::commit();

            return redirect()->route('solutions.index')
                ->with('success', 'Solution created successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Product $solution)
    {
        return view('solution.edit', compact('solution'));
    }

    public function update(ProductRequest $request, Product $solution)
    {
        try {
            DB::beginTransaction();

            // Update Product
            $this->service->createOrUpdate($request, $solution);

            DB::commit();

            return redirect()->route('solutions.index')
                ->with('success', 'Solution updated successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
