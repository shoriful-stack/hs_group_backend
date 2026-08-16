<?php

use App\Http\Controllers\API\V1\AboutUsController;
use App\Http\Controllers\API\V1\BlogController;
use App\Http\Controllers\API\V1\ContactInquiryController;
use App\Http\Controllers\API\V1\HomeController;
use App\Http\Controllers\API\V1\MessagingController;
use App\Http\Controllers\API\V1\ProductCategoryController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\ServiceController;
use App\Http\Controllers\API\V1\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// abc.com/api/v1/oauth/blogs
Route::group( [
    'prefix'    => 'v1/oauth',
    'namespace' => 'API\V1',
], function () {

    // Route::get( '/get_branch', [BranchController::class, 'getBranch'] );
    
    Route::get( '/blogs', [BlogController::class, 'index'] );
    Route::get( '/blog/{slug}', [BlogController::class, 'show'] );

    // Route::get( '/blogCategories', [BlogCategoryController::class, 'index'] );
    Route::get( '/service-categories', [ServiceController::class, 'category'] );
    Route::get( '/projects', [ProjectController::class, 'index'] );
    Route::get( '/project/{slug}', [ProjectController::class, 'show'] );
    Route::get( '/services', [ServiceController::class, 'index'] );
    Route::get( '/service/{slug}', [ServiceController::class, 'show'] );
    Route::get( '/products', [ProductController::class, 'index'] );
    Route::get( '/product/{slug}', [ProductController::class, 'show'] );
    Route::get( '/category/{slug}', [ProductCategoryController::class, 'show'] );
    Route::get( '/product-categories', [ProductController::class, 'category'] );
    Route::get( '/project-categories', [ProjectController::class, 'category'] );
    // Route::get( '/productBrands', [ProductBrandController::class, 'index'] );
    // Route::get( '/productOrigins', [ProductOriginController::class, 'index'] );
    // Route::get( '/product-features', [ProductFeatureController::class, 'index'] );
    // Route::get( '/product-videos', [ProductVideoController::class, 'index'] );
    // Route::get( '/product-documents', [ProductDocumentController::class, 'index'] );
    Route::get( '/tags', [TagController::class, 'index'] );
    Route::get( '/social-links', [AboutUsController::class, 'social_links'] );
    Route::get( '/messagings', [MessagingController::class, 'index'] );
    // Route::get( '/languages', [LanguageController::class, 'index'] );
    Route::get( '/contact-us', [AboutUsController::class, 'contact_us'] );
    // Route::get( '/choose-us', [HomeController::class, 'chooseUs'] );
    Route::get( '/stats', [HomeController::class, 'stat'] );
    Route::get( '/iot', [HomeController::class, 'iot'] );
    Route::get( '/customers', [HomeController::class, 'customer'] );
    Route::get( '/about-us', [AboutUsController::class, 'about'] );
    Route::get( '/branches', [AboutUsController::class, 'company'] );
    // Route::get( '/privacy-policy', [PrivacyPolicyController::class, 'index'] );
    Route::get( '/awards', [HomeController::class, 'award'] );
    Route::get( '/general-settings', [AboutUsController::class, 'general_settings'] );
    Route::get( '/missions', [AboutUsController::class, 'mission'] );
    Route::get( '/visions', [AboutUsController::class, 'vision'] );
    Route::get( '/brands', [AboutUsController::class, 'brands'] );
    Route::get( '/milestones', [AboutUsController::class, 'milestones'] );
    Route::get( '/leadership-messages', [AboutUsController::class, 'leadership_messages'] );
    Route::get( '/sliders', [HomeController::class, 'slider'] );
    // Route::get( '/terms-conditions', [TermsConditionController::class, 'index'] );
    // Route::get( '/pages', [PageController::class, 'index'] );
    // Route::get( '/page/{slug}', [PageController::class, 'show'] );
    // Route::get( '/home-settings', [HomeController::class, 'homeSettings'] );
    Route::post( '/contact-inquiries', [ContactInquiryController::class, 'store'] );
    Route::post( '/quotations', [ContactInquiryController::class, 'quotation'] );

} );

Route::get( '/user', function ( Request $request ) {
    return $request->user();
} )->middleware( 'auth:sanctum' );
