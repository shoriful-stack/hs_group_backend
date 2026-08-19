<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\CapabilityDataTable;
use App\Http\Requests\CapabilityRequest;
use App\Models\Capability;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CapabilityController extends Controller
{
    public function index(CapabilityDataTable $dataTable)
    {
        return $dataTable->render('capability.index');
    }

    public function create()
    {
        return view('capability.create');
    }

    public function store(CapabilityRequest $request)
    {
        try {
            DB::beginTransaction();
            Capability::create([
                'title'     => $request->title,
                'content'   => $request->contents,
                'icon'      => $request->icon,
                'features'  => $request->features,
                'serial_no' => $request->serial_no,
            ]);
            Cache::forget('capabilities');
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(Capability $capability)
    {
        return view('capability.edit', compact('capability'));
    }

    public function update(CapabilityRequest $request, Capability $capability)
    {
        try {
            DB::beginTransaction();
            $capability->update([
                'title'     => $request->title,
                'content'   => $request->contents,
                'icon'      => $request->icon,
                'features'  => $request->features,
                'serial_no' => $request->serial_no,
                'status'    => $request->status ?? $capability->status,
            ]);
            Cache::forget('capabilities');
            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(Capability $capability)
    {
        $capability->delete();
        Cache::forget('capabilities');
        return ReturnMessage::deleteSuccess();
    }
}
