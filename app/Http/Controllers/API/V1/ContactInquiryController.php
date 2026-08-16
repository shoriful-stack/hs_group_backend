<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\ContactInquiryRequest;
use App\Http\Requests\QuotationRequest;
use App\Models\ContactInquiry;
use App\Models\Quotation;
use Illuminate\Http\Request;

class ContactInquiryController extends BaseController {
    public function store( ContactInquiryRequest $request ) {
        $inquiry = ContactInquiry::create( $request->validated() );

        return response()->json( [
            'success' => true,
            'message' => 'Inquiry submitted successfully',
            'data'    => $inquiry,
        ], 201 );
    }
    public function quotation( QuotationRequest $request ) {
        $quotation = Quotation::create( $request->validated() );

        return response()->json( [
            'success' => true,
            'message' => 'Quotation submitted successfully',
            'data'    => $quotation,
        ], 201 );
    }
}
