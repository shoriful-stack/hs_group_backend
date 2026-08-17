<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Controllers\API\V1\HomePageController;
use App\Http\Requests\ChooseUsRequest;
use App\Models\ChooseUs;
use Illuminate\Support\Facades\Auth;

class ChooseUsController extends Controller {
    public function index() {
        $data = ChooseUs::firstOrNew();
        return view( 'chooseUs.index', compact( 'data' ) );
    }

    public function store( ChooseUsRequest $request ) {
        $data = ChooseUs::where( 'branch_id', Auth::user()->branch_id )->first();
        if ( $request->hasFile( 'image' ) ) {
            $image = Helper::imageUpload(
                $request->file( 'image' ),
                uniqid(),
                'choose_us',
            );
        } else {
            $image = $data->image ?? null;
        }

        ChooseUs::updateOrCreate(
            [
                'branch_id' => Auth::user()->branch_id,
            ],
            [
                'title'       => $request->title,
                'content'     => $request->content,
                'features'    => $this->syncFeatureImages( $request, $data?->features ),
                'image'       => $image,
                'language_id' => $request->language_id ?? 1,
            ]
        );

        HomePageController::forgetCache();

        return ReturnMessage::updateSuccess();
    }

    /**
     * @param  mixed  $existingRaw
     * @return list<array{icon: ?string, title: string, short_description: ?string, image: ?string}>|null
     */
    private function syncFeatureImages( ChooseUsRequest $request, mixed $existingRaw ): ?array
    {
        $incoming = $request->input( 'features', [] );
        if ( ! is_array( $incoming ) || $incoming === [] ) {
            return null;
        }

        $existing = $existingRaw;
        if ( is_string( $existingRaw ) && $existingRaw !== '' ) {
            $existing = json_decode( $existingRaw, true );
            if ( is_string( $existing ) ) {
                $existing = json_decode( $existing, true );
            }
        }
        $existing = is_array( $existing ) ? $existing : [];

        $features = [];
        foreach ( $incoming as $index => $feature ) {
            if ( ! is_array( $feature ) ) {
                continue;
            }

            $title = trim( (string) ( $feature['title'] ?? '' ) );
            if ( $title === '' ) {
                continue;
            }

            $image = $feature['existing_image'] ?? ( $existing[$index]['image'] ?? null );
            $uploaded = $request->file( "features.{$index}.image" );
            if ( $uploaded ) {
                $image = Helper::imageUpload(
                    $uploaded,
                    'feature_' . uniqid(),
                    'choose_us/features',
                    is_string( $image ) ? $image : null
                );
            }

            $features[] = [
                'icon'              => isset( $feature['icon'] ) ? (string) $feature['icon'] : null,
                'title'             => $title,
                'short_description' => isset( $feature['short_description'] ) ? (string) $feature['short_description'] : null,
                'image'             => is_string( $image ) && $image !== '' ? $image : null,
            ];
        }

        return $features === [] ? null : $features;
    }
}
