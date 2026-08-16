<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\MessagingDataTable;
use App\Http\Requests\MessagingRequest;
use App\Models\Messaging;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MessagingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MessagingDataTable $dataTable)
    {
        return $dataTable->render('messaging.index');
    }

    public function create()
    {
        $icons = [
            'bi bi-messenger',
            'bi bi-whatsapp',
            'bi bi-instagram',
            'bi bi-linkedin',
        ];
        return view('messaging.create', compact('icons'));
    }

    public function store(MessagingRequest $request)
    {
        try {
            DB::beginTransaction();

            Messaging::create([
                'icon'      => $request->icon,
                'link'      => $request->link,
                'serial_no' => $request->serial_no,
            ]);

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(Messaging $messaging)
    {
        $icons = [
            'bi bi-messenger',
            'bi bi-whatsapp',
            'bi bi-instagram',
            'bi bi-linkedin',
        ];
        return view('messaging.edit', compact('messaging', 'icons'));
    }

    public function update(MessagingRequest $request, Messaging $messaging)
    {
        try {
            DB::beginTransaction();

            $messaging->update([
                'icon'      => $request->icon,
                'link'      => $request->link,
                'serial_no' => $request->serial_no,
                'status'    => $request->status,
            ]);

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(Messaging $messaging)
    {
        $messaging->delete();
        return ReturnMessage::deleteSuccess();
    }
}
