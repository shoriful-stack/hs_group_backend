<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\BlogAuthorController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsEventController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CapabilityController;
use App\Http\Controllers\CareerJobController;
use App\Http\Controllers\ChooseUsController;
use App\Http\Controllers\CKEditorUploadService;
use App\Http\Controllers\ContactInquiryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeSettingController;
use App\Http\Controllers\IotSolutionController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LeadershipMessageController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\OurCustomerController;
use App\Http\Controllers\OurMissionController;
use App\Http\Controllers\OurVisionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectEquipmentCategoryController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceEquipmentCategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('/change-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::patch('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/roles/permissions/{id}', [RoleController::class, 'role_permission'])->name('roles.permission.index');
    Route::post('/roles/permissions/{id}', [RoleController::class, 'role_permission_save'])->name('roles.permission.save');

    Route::get('branches/search', [BranchController::class, 'search'])->name('branch.search');
    Route::resource('branches', BranchController::class);
    Route::post('/branch/switch', [BranchController::class, 'switch'])->name('branch.switch');


    Route::resource('generalSettings', GeneralSettingController::class)->except(['create', 'edit', 'update', 'show', 'destroy']);
    Route::resource('homeSettings', HomeSettingController::class);
    Route::get('languages/search', [LanguageController::class, 'search'])->name('language.search');
    Route::resource('languages', LanguageController::class);
    Route::resource('aboutUs', AboutUsController::class);
    Route::resource('iot', IotSolutionController::class);
    Route::resource('chooseUs', ChooseUsController::class);
    Route::resource('contactUs', ContactUsController::class);
    Route::resource('contactInquiries', ContactInquiryController::class);
    Route::resource('quotations', QuotationController::class);
    Route::resource('ourMissions', OurMissionController::class);
    Route::resource('ourVisions', OurVisionController::class);
    // Route::resource('privacyPolicies', PrivacyPolicyController::class);
    // Route::resource('termsConditions', TermsConditionController::class);
    Route::resource('socialLinks', SocialLinkController::class);
    // Route::resource('messagings', MessagingController::class);
    // Route::get('pages/search', [PageController::class, 'search'])->name('page.search');
    // Route::resource('pages', PageController::class);
    Route::resource('leadership-messages', LeadershipMessageController::class);

    Route::get('blogCategories/search', [BlogCategoryController::class, 'search'])->name('blogCategory.search');
    Route::resource('blogCategories', BlogCategoryController::class);
    Route::resource('blogs', BlogController::class);
    Route::get('blogAuthors/search', [BlogAuthorController::class, 'search'])->name('blogAuthor.search');
    Route::resource('blogAuthors', BlogAuthorController::class);
    Route::resource('newsEvents', NewsEventController::class);
    Route::post('ckEditorUpload', CKEditorUploadService::class)->name('ckEditorUpload');

    Route::get('tags/search', [TagController::class, 'search'])->name('tags.search');
    Route::resource('tags', TagController::class);

    Route::resource('products', ProductController::class);
    Route::resource('productCategories', ProductCategoryController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('projects', ProjectController::class);
    // Route::resource('solutions', SolutionController::class);
    Route::resource('serviceCategories', ServiceCategoryController::class);
    Route::resource('serviceEquipmentCategories', ServiceEquipmentCategoryController::class);
    Route::resource('projectCategories', ProjectCategoryController::class);
    Route::resource('projectEquipmentCategories', ProjectEquipmentCategoryController::class);
    // Route::get('productBrands/search', [ProductBrandController::class, 'search'])->name('productBrands.search');
    // Route::resource('productBrands', ProductBrandController::class);
    // Route::get('productOrigins/search', [ProductOriginController::class, 'search'])->name('productOrigins.search');
    // Route::resource('productOrigins', ProductOriginController::class);

    Route::resource('sliders', SliderController::class);
    Route::resource('awards', AwardController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('ourCustomers', OurCustomerController::class);
    Route::resource('stats', StatController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('milestones', MilestoneController::class);
    Route::resource('capabilities', CapabilityController::class);
    Route::resource('industries', IndustryController::class);
    Route::resource('careerJobs', CareerJobController::class)->except(['show']);
    Route::resource('sustainability', SustainabilityController::class)->only(['index', 'store']);
    Route::get('/storage-app', function () {
        Artisan::call('storage:link');
        return 'Application storage linked successfully.';
    });
});
// Route::get('/{any}', function () {
//     return view('layouts.react_app');
// })->where('any', '^(?!admin).*$');
// Route::get('/{any}', [HomeController::class, 'seo_data'])
//     ->where('any', '^(?!admin).*$');
