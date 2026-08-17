<?php

namespace App\Http\Controllers\API\V1;

use App\Models\IotSolution;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function slider()
    {
        $slider = Cache::remember('sliders', 86400, function () {

            return DB::table('sliders')
                ->select(
                    'id',
                    'title',
                    'content',
                    'sub_title',
                    'sub_content',
                    'image',
                    'video',
                    'serial_no'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $slider
        ], 200);
    }
    public function stat()
    {
        $stat = Cache::remember('stats', 86400, function () {

            return DB::table('stats')
                ->select(
                    'id',
                    'title',
                    'value',
                    'serial_no'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $stat
        ], 200);
    }
    public function iot()
    {
        $iot = Cache::remember('iot', 86400, function () {

            return IotSolution::where('status', 1)
                ->select(
                    'id',
                    'title',
                    'sub_title',
                    'section_heading',
                    'section_sub_heading',
                    'features',
                    'image',
                    'sub_image'
                )
                ->first();
        });

        return response()->json([
            'success' => true,
            'data'    => $iot
        ], 200);
    }
    public function customer()
    {
        $customer = Cache::remember('our_customers', 86400, function () {

            return DB::table('our_customers')
                ->select(
                    'id',
                    'title',
                    'content',
                    'image'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $customer
        ], 200);
    }
    public function award()
    {
        $award = Cache::remember('awards', 86400, function () {

            return DB::table('awards')
                ->select(
                    'id',
                    'title',
                    'content',
                    'image'
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $award
        ], 200);
    }
    // public function homeSettings()
    // {

    //     $home_settings = HomeSetting::with('branch', 'sections.page')
    //         ->where('branch_id', getBranchByDomain()->id)
    //         ->paginate(20);

    //     $array = [
    //         'home_settings' => HomeSettingResource::collection($home_settings),
    //     ];
    //     return $this->sendResponse($array, 'Home Settings retrieved successfully.');
    // }
}
