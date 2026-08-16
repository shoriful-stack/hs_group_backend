<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogTagResource;
use App\Models\Blog;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends BaseController {

    public function index( Request $request ) {

        $blogs = Blog::with(  'category', 'tags' )
        ->where('branch_id', getBranchByDomain()->id)
            ->where( 'status', 2 )
            ->orderBy( "published_at", "desc" );

        if ( $request->has( 'category' ) ) {
            $blogs->whereHas( 'category', function ( $q ) use ( $request ) {
                $q->where( 'slug', $request->get( 'category' ) );
            } );
        }

        if ( $request->has( 'tag' ) ) {
            $blogs->whereHas( 'tags', function ( $q ) use ( $request ) {
                $q->where( 'slug', $request->get( 'tag' ) );
            } );
        }

        if ($request->filled('limit')) {
            $items = $blogs->limit((int) $request->limit)->get();

            return $this->sendResponse([
                'blogs' => BlogResource::collection($items),
            ], 'Blogs retrieved successfully.');
        }

        $perPage = $request->get( 'per_page', 10 );
        $paginated = $blogs->paginate( $perPage );

        $array = [
            'blogs'        => BlogResource::collection( $paginated ),
            'totalResults' => $paginated->total(),
            'currentPage'  => $paginated->currentPage(),
            'totalPages'   => $paginated->lastPage(),
        ];
        return $this->sendResponse( $array, 'Blogs retrieved successfully.' );
    }
    public function blog_tags( Request $request ) {

        $blog_tags = BlogTag::with( 'language' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'blog_tags' => BlogTagResource::collection( $blog_tags ),
        ];
        return $this->sendResponse( $array, 'Blog Tags retrieved successfully.' );
    }

    public function show( $slug ) {

        $blog = Blog::with( 'language', 'category', 'tags' )
            ->where( 'slug', $slug )->first();
        if ( !$blog ) {
            return $this->sendError( 'Blog not found' );
        }
        $array = [
            'blog' => new BlogResource( $blog ),
        ];
        return $this->sendResponse( $array, 'Blogs retrieved successfully.' );
    }

}
