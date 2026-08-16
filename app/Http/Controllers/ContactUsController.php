<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Requests\ContactUsRequest;
use App\Models\ContactUs;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ContactUsController extends Controller
{
    public function index()
    {
       
         $data = ContactUs::query()->where('branch_id',Auth::user()->branch_id)->firstOrNew();
        // $languages = Language::where('status', 1)->pluck('name', 'id');
        return view('contactUs.index', compact('data'));
    }

    public function store(ContactUsRequest $request)
    {
        $data = ContactUs::query()->where('branch_id',Auth::user()->branch_id)->first();
        if ($data) {
            $image = $data->image;
        }

        if ($request->hasFile('image')) {
            $image = Helper::imageUpload(
                $request->file('image'),
                'contact_us_' . uniqid(),
                'contact_us',
                @$data->image ?? null
            );
        }

        ContactUs::updateOrCreate(
            ['branch_id' => Auth::user()->branch_id],
            [
                'image'           => $image,
                'address'         => $request->address,
                'lat'             => $request->lat,
                'lang'            => $request->lang,
                'map'             => $request->map,
                'primary_phone'   => $request->primary_phone,
                'secondary_phone' => $request->secondary_phone,
                'primary_email'   => $request->primary_email,
                'secondary_email' => $request->secondary_email,
                'whatsapp_number' => $request->whatsapp_number,
                'language_id'     => $request->language_id ?? 1,
            ]
        );

        Cache::forget('contact_us');

        return ReturnMessage::updateSuccess();
    }
}
