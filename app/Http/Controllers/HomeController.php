<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $totalCustomer = OurCustomer::count();
        $totalProject = Project::count();
        $totalBrand = Brand::count();
        $totalProduct = Product::count();
        $totalService = Service::count();

        return view('home', compact('totalProject', 'totalBrand', 'totalProduct', 'totalService'));
    }
    // public function seo_data()
    // {
    //     $seo = GeneralSetting::first();
    //     // $languages = Language::query()->pluck('name', 'id');
    //     return view('layouts.react_app', compact('seo'));
    // }
}
