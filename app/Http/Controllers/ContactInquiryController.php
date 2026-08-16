<?php

namespace App\Http\Controllers;

use App\DataTables\ContactInquiryDataTable;

class ContactInquiryController extends Controller {
    public function index( ContactInquiryDataTable $dataTable ) {
        return $dataTable->render( "contactInquiry.index" );
    }
}
