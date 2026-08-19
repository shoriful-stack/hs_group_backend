<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\IndustryDataTable;
use App\Http\Requests\IndustryRequest;
use App\Models\Industry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndustryController extends Controller
{
    public function index(IndustryDataTable $dataTable)
    {
        return $dataTable->render('industry.index');
    }

    public function create()
    {
        return view('industry.create');
    }

    public function store(IndustryRequest $request)
    {
        try {
            DB::beginTransaction();
            Industry::create([
                'title'     => $request->title,
                'content'   => $request->contents,
                'icon'      => $request->icon,
                'serial_no' => $request->serial_no,
            ]);
            Cache::forget('industries');
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(Industry $industry)
    {
        return view('industry.edit', compact('industry'));
    }

    public function update(IndustryRequest $request, Industry $industry)
    {
        try {
            DB::beginTransaction();
            $industry->update([
                'title'     => $request->title,
                'content'   => $request->contents,
                'icon'      => $request->icon,
                'serial_no' => $request->serial_no,
                'status'    => $request->status ?? $industry->status,
            ]);
            Cache::forget('industries');
            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(Industry $industry)
    {
        $industry->delete();
        Cache::forget('industries');
        return ReturnMessage::deleteSuccess();
    }
}
