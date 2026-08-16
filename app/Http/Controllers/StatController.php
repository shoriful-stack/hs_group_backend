<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\StatDataTable;
use App\Http\Requests\StatRequest;
use App\Models\Stat;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StatDataTable $statDataTable)
    {
        return $statDataTable->render('stat.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatRequest $request)
    {
        try {
            DB::beginTransaction();

            Stat::create([
                'title'       => $request->title,
                'value'     => $request->value,
                'serial_no'   => $request->serial_no,
            ]);
            Cache::forget('stats');
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
    public function show(Stat $stat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stat $stat)
    {
        return view('stat.edit', compact('stat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stat $stat)
    {
        try {
            DB::beginTransaction();

            $stat->update([
                'title'       => $request->title,
                'value' => $request->value,
                'serial_no'   => $request->serial_no,
                'status'      => $request->status,
            ]);

            Cache::forget('stats');

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
    public function destroy(Stat $stat)
    {
        $stat->delete();
        Cache::forget('stats');
        return ReturnMessage::deleteSuccess();
    }
}
