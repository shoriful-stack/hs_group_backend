<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\SliderDataTable;
use App\Http\Controllers\API\V1\HomePageController;
use App\Http\Requests\SliderRequest;
use App\Models\Language;
use App\Models\Slider;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller {
    public function index( SliderDataTable $dataTable ) {
        return $dataTable->render( 'slider.index' );
    }

    public function create() {
        return view( 'slider.create' );
    }

    public function store( SliderRequest $request ) {
        try {
            DB::beginTransaction();

            $image = null;
            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'sliders'
                );
            } else {
                $image = '/assets/images/default-slider.png';
            }

            $video = null;
            if ( $request->hasFile( 'video' ) ) {
                $video = Helper::documentUpload(
                    $request->file( 'video' ),
                    'slider_video_' . uniqid(),
                    'sliders/videos'
                );
            }

            Slider::create( [
                'language_id' => $request->language_id ?? 1,
                'title'       => $request->title,
                'content'     => $request->contents,
                'sub_title'   => $request->sub_title,
                'sub_content' => $request->sub_content,
                'image'       => $image,
                'video'       => $video,
                'url'         => $request->url,
                'serial_no'   => $request->serial_no,
            ] );

            Cache::forget('sliders');
            HomePageController::forgetCache();
            DB::commit();
            return ReturnMessage::insertSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( Slider $slider ) {
        // $languages = Language::where( 'status', 1 )->pluck( 'name', 'id' );
        return view( 'slider.edit', compact('slider') );
    }

    public function update( SliderRequest $request, Slider $slider ) {
        try {
            DB::beginTransaction();

            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'sliders',
                    $slider->image
                );
            } else {
                $image = $slider->image ?? '/assets/images/default-slider.png';
            }

            $video = $slider->video;
            if ( $request->hasFile( 'video' ) ) {
                $video = Helper::documentUpload(
                    $request->file( 'video' ),
                    'slider_video_' . uniqid(),
                    'sliders/videos',
                    $slider->video
                );
            }

            $slider->update( [
                'language_id' => $request->language_id ?? 1,
                'title'       => $request->title,
                'content'     => $request->contents,
                'sub_title'   => $request->sub_title,
                'sub_content' => $request->sub_content,
                'image'       => $image,
                'video'       => $video,
                'url'         => $request->url,
                'serial_no'   => $request->serial_no,
                'status'      => $request->status,
            ] );
            
            Cache::forget('sliders');
            HomePageController::forgetCache();
            DB::commit();
            return ReturnMessage::updateSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function destroy( Slider $slider ) {
        $slider->delete();
        return ReturnMessage::deleteSuccess();
    }
}
