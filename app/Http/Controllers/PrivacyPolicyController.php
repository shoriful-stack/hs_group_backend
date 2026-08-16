<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\Http\Requests\PrivacyPolicyRequest;
use App\Models\Language;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Auth;

class PrivacyPolicyController extends Controller {
    public function index() {
        $data = PrivacyPolicy::query()->firstOrNew();
        $languages = Language::where('status', 1)->pluck('name', 'id');
        return view( 'privacyPolicy.index', compact( 'data', 'languages' ) );
    }

    public function store( PrivacyPolicyRequest $request ) {

        PrivacyPolicy::updateOrCreate(
            ['branch_id' => Auth::user()->branch_id],
            [
                'title'       => $request->title,
                'content'     => $request->contents,
                'serial_no'   => $request->serial_no,
                'language_id' => $request->language_id,
            ]
        );

        return ReturnMessage::updateSuccess();
    }
}
