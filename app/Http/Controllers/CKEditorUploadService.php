<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorUploadService extends Controller {
    /**
     * Handle the incoming request.
     */
    public function __invoke( Request $request ) {
        if ( $request->hasFile( 'upload' ) ) {
            $file = $request->file( 'upload' );
            $ext = strtolower( $file->getClientOriginalExtension() );
            if ( !in_array( $ext, ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'] ) ) {
                return response()->json( ['error' => 'Invalid file type'], 400 );
            }

            if ( $file->getSize() > 5 * 1024 * 1024 ) {
                return response()->json( ['error' => 'File too large'], 400 );
            }

            $folder = in_array( $ext, ['mp4', 'mov', 'avi'] ) ? 'posts/videos' : 'posts/images';
            $path = $file->store( $folder, 'public' );

            return response()->json( [
                'uploaded' => true,
                'url'      => asset( 'storage/' . $path ),
                'fileName' => $file->getClientOriginalName(),
            ] );
        }

        return response()->json( ['error' => 'No file uploaded'], 400 );
    }
}
