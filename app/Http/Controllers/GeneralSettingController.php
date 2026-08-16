<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Requests\generalSettingRequest;
use App\Models\GeneralSetting;
use App\Models\Language;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $data = GeneralSetting::query()->firstOrNew();
        // $languages = Language::query()->pluck('name', 'id');
        return view('generalSetting.index', compact('data'));
    }

    public function store(generalSettingRequest $request)
    {
        // return $request;
        try {
            DB::beginTransaction();

            $data = GeneralSetting::query()->where('branch_id', Auth::user()->branch_id)->first();

            $favicon     = $this->handleUpload($request, 'favicon', 'favicon', 'general_setting', $data->favicon ?? null);
            $logo_header = $this->handleUpload($request, 'logo_header', 'logo_header', 'general_setting', $data->logo_header ?? null);
            $logo_footer = $this->handleUpload($request, 'logo_footer', 'logo_footer', 'general_setting', $data->logo_footer ?? null);

            GeneralSetting::updateOrCreate(
                ['branch_id' => Auth::user()->branch_id],
                [
                    'language_id' => $request->language_id ?? 1,
                    'title'       => $request->title,
                    'favicon'     => $favicon,
                    'logo_header' => $logo_header,
                    'logo_footer' => $logo_footer,
                    'description' => $request->description,
                    'keywords'    => $request->keywords,
                    'cookies'     => $request->cookies_name,
                ]
            );

            Cache::forget('general_settings');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    private function handleUpload($request, $field, $prefix, $folder, $oldFile = null)
    {
        if ($request->hasFile($field)) {
            return Helper::imageUpload(
                $request->file($field),
                $prefix . '_' . uniqid(),
                $folder,
                $oldFile
            );
        }
        return $oldFile;
    }
}
