<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Requests\ChooseUsRequest;
use App\Models\ChooseUs;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class ChooseUsController extends Controller {
    public function index() {
        $data = ChooseUs::firstOrNew();
        $languages = Language::where( 'status', 1 )->pluck( 'name', 'id' );
        return view( 'chooseUs.index', compact( 'data', 'languages' ) );
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

        $features = $request->features ? json_encode( $request->features ) : null;

        ChooseUs::updateOrCreate(
            [
                'branch_id' => Auth::user()->branch_id,
            ],
            [
                'title'       => $request->title,
                'content'     => $request->content,
                'features'    => $features,
                'image'       => $image,
                'language_id' => $request->language_id,
            ]
        );

        return ReturnMessage::updateSuccess();
    }
}
