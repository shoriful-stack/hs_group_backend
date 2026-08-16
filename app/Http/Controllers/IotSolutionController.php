<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\Models\IotSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IotSolutionController extends Controller
{
    public function index()
    {
        $data = IotSolution::first();

        return view('iotsolution.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'sub_title'           => 'nullable|string',
            'section_heading'     => 'nullable|string|max:255',
            'section_sub_heading' => 'nullable|string|max:255',
            'features.*'          => 'nullable|string|max:255',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sub_image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $existing = IotSolution::first();

        $image       = $existing?->image;
        $subImage    = $existing?->sub_image;

        if ($request->hasFile('image')) {
            $image = Helper::imageUpload($request->file('image'), 'iot_main_' . uniqid(), 'iot', $existing?->image);
        }

        if ($request->hasFile('sub_image')) {
            $subImage = Helper::imageUpload($request->file('sub_image'), 'iot_sub_' . uniqid(), 'iot', $existing?->sub_image);
        }

        $features = collect($request->features)
            ->filter(fn($f) => !empty(trim($f)))
            ->values()
            ->toArray();

        IotSolution::updateOrCreate(
            ['id' => $existing?->id],
            [
                'title'               => $request->title,
                'sub_title'           => $request->sub_title,
                'section_heading'     => $request->section_heading,
                'section_sub_heading' => $request->section_sub_heading,
                'features'            => !empty($features) ? $features : null,
                'image'               => $image,
                'sub_image'           => $subImage,
                'status'              => $request->status ?? 1,
                'created_by'          => $existing ? $existing->created_by : auth()->id(),
                'updated_by'          => auth()->id(),
            ]
        );

        Cache::forget('iot');

        return redirect()->back()->with('success', 'IOT Section Updated Successfully');
    }
}
