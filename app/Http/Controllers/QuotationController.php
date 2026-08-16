<?php

namespace App\Http\Controllers;

use App\DataTables\QuotationDataTable;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(QuotationDataTable $dataTable)
    {
        return $dataTable->render("quotation.index");
    }
}
