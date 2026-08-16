<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AboutUsController
{
    // public function index()
    // {
    //     $about_us = AboutUs::with('branch')
    //         ->where('branch_id', getBranchByDomain()->id)
    //         ->select('id', 'branch_id', 'title', 'content', 'image')
    //         ->get();

    //     $array = [
    //         'about_us' => AboutUsResource::collection($about_us),
    //     ];
    //     return $this->sendResponse($array, 'About Us retrieved successfully.');
    // }

    public function general_settings()
    {
        $setting = Cache::remember('general_settings', 86400, function () {

            return DB::table('general_settings')
                ->select(
                    'id',
                    'title',
                    'favicon',
                    'logo_header',
                    'logo_footer',
                    'description',
                    'keywords'
                )
                ->first();
        });

        return response()->json([
            'success' => true,
            'data'    => $setting
        ], 200);
    }
    public function about()
    {
        $about = Cache::remember('about_us', 86400, function () {

            return DB::table('about_us')
                ->select(
                    'id',
                    'title',
                    'content',
                    'image',
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $about
        ], 200);
    }
    public function contact_us()
    {
        $contact_us = Cache::remember('contact_us', 86400, function () {

            return DB::table('contact_us')
                ->select(
                    'id',
                    'branch_id',
                    'address',
                    'lat',
                    'lang',
                    'map',
                    'primary_phone',
                    'secondary_phone',
                    'primary_email',
                    'secondary_email',
                    'whatsapp_number',
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $contact_us
        ], 200);
    }
    public function mission()
    {
        $mission = Cache::remember('our_missions', 86400, function () {

            return DB::table('our_missions')
                ->select(
                    'content',
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $mission
        ], 200);
    }
    public function vision()
    {
        $vision = Cache::remember('our_visions', 86400, function () {

            return DB::table('our_visions')
                ->select(
                    'content',
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $vision
        ], 200);
    }
    public function company()
    {
        $company = Cache::remember('branches', 86400, function () {

            return DB::table('branches')
            ->whereNull('deleted_at')
                ->select(
                    'id',
                    'name',
                    'image',
                    'content',
                    'domain',
                    'is_default'
                )
                ->where('status', 1)
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $company
        ], 200);
    }
    public function brands()
    {
        $brand = Cache::remember('brands', 86400, function () {

            return DB::table('brands')
                ->whereNull('deleted_at')
                ->select(
                    'id',
                    'title',
                    'image',
                    'content',
                    'domain',
                )
                ->where('status', 1)
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $brand
        ], 200);
    }
    public function milestones()
    {
        $milestone = Cache::remember('milestones', 86400, function () {

            return DB::table('milestones')
                ->select(
                    'id',
                    'year',
                    'title',
                    'content',
                    'serial_no',
                )
                ->orderByDesc('serial_no')
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $milestone
        ], 200);
    }
    public function leadership_messages()
    {
        $leadership_message = Cache::remember('leadership_messages', 86400, function () {

            return DB::table('leadership_messages')
                ->select(
                    'id',
                    'name',
                    'designation',
                    'image',
                    'content',
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $leadership_message
        ], 200);
    }
    public function social_links()
    {
        $social_link = Cache::remember('social-links', 86400, function () {

            return DB::table('social_links')
                ->select(
                    'id',
                    'icon',
                    'link',
                )
                ->get();
        });

        return response()->json([
            'success' => true,
            'data'    => $social_link
        ], 200);
    }
}
