<?php

use App\Http\Controllers\API\V1\AboutUsController;
use App\Http\Controllers\API\V1\BlogController;
use App\Http\Controllers\API\V1\ContactInquiryController;
use App\Http\Controllers\API\V1\HomeController;
use App\Http\Controllers\API\V1\HomePageController;
use App\Http\Controllers\API\V1\LayoutController;
use App\Http\Controllers\API\V1\MessagingController;
use App\Http\Controllers\API\V1\ProductCategoryController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\ServiceController;
use App\Http\Controllers\API\V1\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public CMS API  →  /api/v1/*
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blog/{slug}', [BlogController::class, 'show']);
    Route::get('/blog-categories', [BlogController::class, 'categories']);
    Route::get('/blog-authors', [BlogController::class, 'authors']);
    Route::get('/events', [BlogController::class, 'events']);

    Route::get('/service-categories', [ServiceController::class, 'category']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/service/{slug}', [ServiceController::class, 'show']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/project/{slug}', [ProjectController::class, 'show']);
    Route::get('/project-categories', [ProjectController::class, 'category']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/product/{slug}', [ProductController::class, 'show']);
    Route::get('/product-categories', [ProductController::class, 'category']);
    Route::get('/category/{slug}', [ProductCategoryController::class, 'show']);

    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/social-links', [AboutUsController::class, 'social_links']);
    Route::get('/messagings', [MessagingController::class, 'index']);
    Route::get('/contact-us', [AboutUsController::class, 'contact_us']);
    Route::get('/about-us', [AboutUsController::class, 'about']);
    Route::get('/branches', [AboutUsController::class, 'company']);
    Route::get('/general-settings', [AboutUsController::class, 'general_settings']);
    Route::get('/missions', [AboutUsController::class, 'mission']);
    Route::get('/visions', [AboutUsController::class, 'vision']);
    Route::get('/brands', [AboutUsController::class, 'brands']);
    Route::get('/milestones', [AboutUsController::class, 'milestones']);
    Route::get('/leadership-messages', [AboutUsController::class, 'leadership_messages']);
    Route::get('/capabilities', [AboutUsController::class, 'capabilities']);
    Route::get('/industries', [AboutUsController::class, 'industries']);
    Route::get('/sustainability', [AboutUsController::class, 'sustainability']);

    Route::get('/stats', [HomeController::class, 'stat']);
    Route::get('/iot', [HomeController::class, 'iot']);
    Route::get('/customers', [HomeController::class, 'customer']);
    Route::get('/awards', [HomeController::class, 'award']);
    Route::get('/testimonials', [HomeController::class, 'testimonial']);
    Route::get('/sliders', [HomeController::class, 'slider']);
    Route::get('/home/static-data', [HomePageController::class, 'staticData']);
    Route::get('/layout', [LayoutController::class, 'show']);

    Route::post('/contact-inquiries', [ContactInquiryController::class, 'store']);
    Route::post('/quotations', [ContactInquiryController::class, 'quotation']);
});

/*
|--------------------------------------------------------------------------
| Authenticated API  →  /api/v1/oauth/*
|--------------------------------------------------------------------------
*/
Route::prefix('v1/oauth')->middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
