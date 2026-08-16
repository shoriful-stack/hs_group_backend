<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\Models\OurMission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OurMissionController extends Controller
{
    public function index()
    {
        $data = OurMission::query()->firstOrNew();
        return view('ourMission.index', compact('data'));
    }

    public function store(Request $request)
    {
        OurMission::updateOrCreate(
            ['branch_id' => Auth::user()->branch_id],
            [
                'title' => $request->title ?? 'N/A',
                'content'     => $request->contents ?? null,
                'language_id' => $request->language_id ?? 1,
            ]
        );

        Cache::forget('our_missions');

        return ReturnMessage::updateSuccess();
    }
}
