<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AboutUsController extends Controller
{
    public function index()
    {
        $data = AboutUs::query()->where('branch_id', Auth::user()->branch_id)->firstOrNew();
        return view('about_us.index', compact('data'));
    }

    public function store(AboutUsRequest $request)
    {
        $data = AboutUs::query()
            ->where('branch_id', Auth::user()->branch_id)
            ->first();

        if ($data) {
            $image = $data->image;
        }

        if ($request->hasFile('image')) {
            $image = Helper::imageUpload(
                $request->file('image'),
                'about_us_' . uniqid(),
                'about_us',
                @$data->image ?? null
            );
        }

        AboutUs::updateOrCreate(
            ['branch_id' => Auth::user()->branch_id],
            [
                'language_id' => $request->language_id ?? 1,
                'type'        => 1,
                'title'       => $request->title,
                'content'     => $request->contents,
                'image'       => $image ?? null,
                'serial_no'   => $request->serial_no ?? 1,
                'status'      => 1,
            ]
        );

        Cache::forget('about_us');

        return ReturnMessage::updateSuccess();
    }
}
