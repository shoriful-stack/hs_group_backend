<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class Helper {
    /**
     * Upload & compress an image
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param int|null $width
     * @param int|null $height
     * @param int $quality
     * @return string $path
     */

    public static function imageUpload( $file, $filename, $folder, $oldFilePath = null, $width = null, $height = null, $quality = 80 ) {
        // create new manager instance with Imagick driver
        $manager = ImageManager::gd();

        if ( !empty( $oldFilePath ) ) {
            $relativePath = str_replace( 'storage/', '', $oldFilePath ); // remove "storage/"
            if ( Storage::disk( 'public' )->exists( $relativePath ) ) {
                Storage::disk( 'public' )->delete( $relativePath );
            }
        }
        // unique filename

        $branchId = Auth::user()->branch_id ?? null;
        // $slag = Branch::find($branchId)?->name ?? GeneralSetting::value('title');

        $slag = $branchId;

        $extension = strtolower($file->getClientOriginalExtension());
        $allowedFormats = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($extension, $allowedFormats)) 
        {
            $extension = 'jpeg';
        }

        $filename = $filename . '.' . $extension;
        $path = storage_path( "app/public/{$slag}/{$folder}/{$filename}" );

        // make directory if not exists
        if ( !file_exists( dirname( $path ) ) ) {
            mkdir( dirname( $path ), 0777, true );
        }

        // read file
        $image = $manager->read( $file );

        // resize if needed
        if ( $width && $height ) {
            $image->resize( $width, $height, function ( $constraint ) {
                $constraint->aspectRatio();
                $constraint->upsize();
            } );
        }

        switch ($extension) {
        case 'png':
            $image->toPng()->save($path);
            break;

        case 'webp':
            $image->toWebp($quality)->save($path);
            break;

        case 'jpg':
        case 'jpeg':
        default:
            $image->toJpeg($quality)->save($path);
            break;
        }

        return "storage/{$slag}/{$folder}/{$filename}";
    }

    public static function documentUpload( $file, $filename, $folder, $oldFilePath = null ) {
        if ( !empty( $oldFilePath ) ) {
            $relativePath = str_replace( 'storage/', '', $oldFilePath );
            if ( Storage::disk( 'public' )->exists( $relativePath ) ) {
                Storage::disk( 'public' )->delete( $relativePath );
            }
        }

        $branchId = Auth::user()->branch_id ?? null;
        $slag = $branchId;

        $filename = $filename . '.' . $file->getClientOriginalExtension();
        $path = storage_path( "app/public/{$slag}/{$folder}/{$filename}" );

        if ( !file_exists( dirname( $path ) ) ) {
            mkdir( dirname( $path ), 0777, true );
        }

        $file->move( dirname( $path ), $filename );

        return "storage/{$slag}/{$folder}/{$filename}";
    }
}
