<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\PageDataTable;
use App\Http\Requests\PageRequest;
use App\Models\HomeSection;
use App\Models\HomeSetting;
use App\Models\Page;
use App\Services\SearchService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {
    public function index( PageDataTable $dataTable ) {
        return $dataTable->render( 'page.index' );
    }

    public function create() {
        return view( 'page.create' );
    }

    public function store( PageRequest $request ) {
        try {
            DB::beginTransaction();

            $mainImage = null;
            $subImage = null;

            if ( $request->hasFile( 'main_image' ) ) {
                $mainImage = Helper::imageUpload(
                    $request->file( 'main_image' ),
                    uniqid(),
                    'pages'
                );
            }

            if ( $request->hasFile( 'sub_image' ) ) {
                $subImage = Helper::imageUpload(
                    $request->file( 'sub_image' ),
                    uniqid(),
                    'pages'
                );
            }

            $page = new Page();
            $page->branch_id = $request->branch_id ?? 1;
            $page->language_id = $request->language_id ?? 1;
            $page->title = $request->title;
            $page->content = $request->content;
            $page->main_image = $mainImage;
            $page->sub_image = $subImage;
            $page->seo_title = $request->seo_title;
            $page->seo_description = $request->seo_description;
            $page->seo_keywords = $request->seo_keywords;
            $page->serial_no = $request->serial_no ?? 1;
            $page->status = $request->status ?? 2;
            $page->published_at = $request->published_at;
            $page->save();

            DB::commit();
            return redirect()->route('pages.index')->with('success', 'Page created successfully!');
        } catch ( QueryException $exp ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $exp->getMessage() );
        }
    }

    public function edit( Page $page ) {
        return view( 'page.edit', compact( 'page' ) );
    }

    public function update( PageRequest $request, Page $page ) {
        try {
            DB::beginTransaction();

            if ( $request->hasFile( 'main_image' ) ) {
                $mainImage = Helper::imageUpload(
                    $request->file( 'main_image' ),
                    uniqid(),
                    'pages',
                    $page->main_image
                );
                $page->main_image = $mainImage;
            }

            if ( $request->hasFile( 'sub_image' ) ) {
                $subImage = Helper::imageUpload(
                    $request->file( 'sub_image' ),
                    uniqid(),
                    'pages',
                    $page->sub_image
                );
                $page->sub_image = $subImage;
            }

            $page->language_id = $request->language_id;
            $page->title = $request->title;
            $page->content = $request->content;
            $page->seo_title = $request->seo_title;
            $page->seo_description = $request->seo_description;
            $page->seo_keywords = $request->seo_keywords;
            $page->serial_no = $request->serial_no;
            $page->status = $request->status;
            $page->published_at = $request->published_at;
            $page->save();

            DB::commit();
            return redirect()->route('pages.index')->with('success', 'Page updated successfully!');
        } catch ( QueryException $exp ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $exp->getMessage() );
        }
    }

    public function destroy( Page $page ) {
        try {
            $isUsed = HomeSection::where('page_id', $page->id)->exists();

            if($isUsed){
                return ReturnMessage::customMessage('error', 'Already in use, can not delete it!');
            }

            $page->delete();
            return ReturnMessage::deleteSuccess();
        } catch ( QueryException $exp ) {
            return ReturnMessage::customMessage( 'error', $exp->getMessage() );
        }
    }

    public function search( Request $request ) {
        $results = ( new SearchService )->search( Page::class, $request, ['id', 'title'], 'title');
        return response()->json( $results );
    }
}
