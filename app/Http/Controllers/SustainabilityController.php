<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Requests\SustainabilityRequest;
use App\Models\Sustainability;
use Illuminate\Support\Facades\Cache;

class SustainabilityController extends Controller
{
    public function index()
    {
        $data = Sustainability::query()->firstOrNew();
        return view('sustainability.index', compact('data'));
    }

    public function store(SustainabilityRequest $request)
    {
        $existing = Sustainability::query()->first();
        $image = $existing?->image;

        if ($request->hasFile('image')) {
            $image = Helper::imageUpload(
                $request->file('image'),
                'sustainability_' . uniqid(),
                'sustainability',
                $image
            );
        }

        Sustainability::updateOrCreate(
            ['id' => $existing?->id],
            [
                'title'     => $request->title,
                'subtitle'  => $request->subtitle,
                'sub_title' => $request->sub_title,
                'content'   => $request->contents,
                'quote'     => $request->quote,
                'closing'   => $request->closing,
                'image'     => $image,
            ]
        );

        Cache::forget('sustainability');

        return ReturnMessage::updateSuccess();
    }
}
