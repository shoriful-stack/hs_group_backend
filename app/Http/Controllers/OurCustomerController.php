<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\OurCustomerDataTable;
use App\Http\Requests\OurCustomerRequest;
use App\Models\OurCustomer;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OurCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OurCustomerDataTable $dataTable)
    {
        return $dataTable->render('ourCustomer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ourCustomer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OurCustomerRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'ourCustomer'
                );
            }

            $ourCustomer = new OurCustomer();
            $ourCustomer->title = $request->title ?? '';
            $ourCustomer->content = $request->content ?? '';
            $ourCustomer->image = $image ?? null;
            $ourCustomer->save();

            Cache::forget('our_customers');
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OurCustomer $ourCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurCustomer $ourCustomer)
    {
        return view('ourCustomer.edit', compact('ourCustomer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OurCustomerRequest $request, OurCustomer $ourCustomer)
    {
        try {
            DB::beginTransaction();

            $image = $ourCustomer->image;

            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'ourCustomer',
                    $ourCustomer->image
                );
            }

            $ourCustomer->title = $request->title ?? '';
            $ourCustomer->content = $request->content ?? '';
            $ourCustomer->image = $image;
            $ourCustomer->save();

            Cache::forget('our_customers');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OurCustomer $ourCustomer)
    {
        try {
            $ourCustomer->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
