<?php

namespace App\Services;

use App\CustomClass\Helper;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductOverview;
use App\Models\ProductApplication;
use App\Models\ProductGallery;
use App\Models\ProductDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductService
{
    public function createOrUpdate($request, $id = null)
    {
        try {

            DB::beginTransaction();

            $product = $id
                ? Product::lockForUpdate()->findOrFail($id)
                : new Product();

            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'product',
                    $product->image
                );
                $product->image = $image;
            }

            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->subtitle = $request->subtitle;
            $product->description = $request->description;
            $product->technical_specifications = $request->technical_specifications;

            $product->seo_title = $request->seo_title;
            $product->seo_keywords = $request->seo_keywords;
            $product->seo_description = $request->seo_description;

            $product->save();

            if ($id) {
                $product->overviews()->delete();
                $product->features()->delete();
                $product->applications()->delete();
            }

            if ($request->overview_titles) {

                foreach ($request->overview_titles as $titles) {

                    $items = explode(',', $titles);

                    foreach ($items as $item) {

                        $item = trim($item);

                        if (!$item) continue;

                        ProductOverview::create([
                            'product_id' => $product->id,
                            'title' => $item
                        ]);
                    }
                }
            }

            if ($request->feature_titles) {

                foreach ($request->feature_titles as $titles) {

                    $items = explode(',', $titles);

                    foreach ($items as $item) {

                        $item = trim($item);

                        if (!$item) continue;

                        ProductFeature::create([
                            'product_id' => $product->id,
                            'title' => $item
                        ]);
                    }
                }
            }

            if ($request->application_titles) {

                foreach ($request->application_titles as $titles) {

                    $items = explode(',', $titles);

                    foreach ($items as $item) {

                        $item = trim($item);

                        if (!$item) continue;

                        ProductApplication::create([
                            'product_id' => $product->id,
                            'title' => $item
                        ]);
                    }
                }
            }

            if ($request->hasFile('product_images')) {

                foreach ($request->file('product_images') as $imageFile) {

                    if (!$imageFile) continue;

                    $uploadedPath = Helper::imageUpload(
                        $imageFile,
                        uniqid(),
                        'product_gallery'
                    );

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $uploadedPath
                    ]);
                }
            }

            if ($request->documents_title) {

                foreach ($request->documents_title as $key => $title) {

                    if (!$title) continue;

                    $filePath = null;

                    if ($request->hasFile('product_documents') && isset($request->file('product_documents')[$key])) {

                        $file = $request->file('product_documents')[$key];

                        $filePath = Helper::documentUpload(
                            $file,
                            uniqid(),
                            'product_documents'
                        );
                    }

                    ProductDocument::create([
                        'product_id' => $product->id,
                        'title' => $title,
                        'link' => $request->documents_link[$key] ?? null,
                        'description' => $request->documents_description[$key] ?? null,
                        'attachment' => $filePath
                    ]);
                }
            }


            DB::commit();

            return [
                'success' => true,
                'message' => $id
                    ? 'Product updated successfully.'
                    : 'Product created successfully.'
            ];
        } catch (QueryException $e) {

            DB::rollBack();

            Log::error('DB Error in ProductService: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Database error occurred while processing the product.'
            ];
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Error in ProductService: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
