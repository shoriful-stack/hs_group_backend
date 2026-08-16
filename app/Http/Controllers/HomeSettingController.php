<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\Http\Requests\HomeSettingRequest;
use App\Models\HomeSection;
use App\Models\HomeSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeSettingController extends Controller {
    public function index() {
        $data = HomeSetting::firstOrNew();
        $sections = HomeSection::where('branch_id', Auth::user()->branch_id)->get();
        return view( 'homeSetting.index', compact( 'data', 'sections' ) );
    }

    public function store( HomeSettingRequest $request ) {
        try {
            DB::beginTransaction();
            $homeSetting = HomeSetting::firstOrNew();

            $homeSetting->section_enable = $request->has( 'section_enable' ) ? 1 : 0;
            $homeSetting->brand_enable = $request->has( 'brand_enable' ) ? 1 : 0;
            $homeSetting->blog_enable = $request->has( 'blog_enable' ) ? 1 : 0;
            $homeSetting->video_enable = $request->has( 'video_enable' ) ? 1 : 0;

            $homeSetting->video_url = $request->video_url;

            if ( $request->hasFile( 'video_thumb' ) ) {
                $homeSetting->video_thumb = Helper::imageUpload(
                    $request->file( 'video_thumb' ),
                    uniqid(),
                    'video_thumbs'
                );
            }

            if ( $request->hasFile( 'since_image' ) ) {
                $homeSetting->since_image = Helper::imageUpload(
                    $request->file( 'since_image' ),
                    uniqid(),
                    'since_images'
                );
            }

            $homeSetting->save();

            if ( $homeSetting->section_enable && $request->filled( 'sections' ) ) {
                HomeSection::query()->delete();

                foreach ( $request->sections as $section ) {
                    HomeSection::create( [
                        'language_id' => 1,
                        'title'       => $section['title'] ?? null,
                        'position'    => $section['position'] ?? 1,
                        'page_id'     => $section['page'] ?? null,
                    ] );
                }
            } else {
                HomeSection::query()->delete();
            }

            DB::commit();

            return redirect()->back()->with( 'success', 'Home settings saved successfully.' );
        } catch ( QueryException $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', 'Something went wrong: ' . $e->getMessage() );
        }
    }

}
