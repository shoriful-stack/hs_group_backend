<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\LeadershipMessageDataTable;
use App\Enums\Status;
use App\Models\LeadershipMessage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class LeadershipMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeadershipMessageDataTable $leadershipMessageDataTable)
    {
        return $leadershipMessageDataTable->render('leadershipMessage.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leadershipMessage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:leadership_messages,name',
                'designation'  => 'required|string',
                'image'   => 'required|max:1024|mimes:png,jpeg,jpg,webp',
                'contents' => 'required|string',
            ])->validate();

            $image = '';
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    'leadership_message' . uniqid(),
                    'leadership_message',
                );
            }

            $leadershipMessage = new LeadershipMessage();
            $leadershipMessage->name = $request->name;
            $leadershipMessage->designation = $request->designation;
            $leadershipMessage->image = $image;
            $leadershipMessage->content = $request->contents;
            $leadershipMessage->save();

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
    public function show(LeadershipMessage $leadershipMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadershipMessage $leadershipMessage)
    {
        return view('leadershipMessage.edit', compact('leadershipMessage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadershipMessage $leadershipMessage)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name'    => 'required|string|unique:leadership_messages,name,' . $leadershipMessage->id,
                'designation'    => 'nullable|string',
                'image'   => 'nullable|max:1024|mimes:png,jpeg,jpg,webp',
                'contents' => 'nullable|string',
                'status'  => new Enum(Status::class),
            ])->validate();

            $image = $leadershipMessage->image;
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    'leadership_message' . uniqid(),
                    'leadership_message',
                    $leadershipMessage->image
                );
            }

            $leadershipMessage->name = $request->name;
            $leadershipMessage->designation = $request->designation;
            $leadershipMessage->image = $image;
            $leadershipMessage->content = $request->contents;
            $leadershipMessage->status = $request->status;
            $leadershipMessage->save();

            Cache::forget('leadership_messages');

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
    public function destroy(LeadershipMessage $leadershipMessage)
    {
        try {
            $leadershipMessage->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
