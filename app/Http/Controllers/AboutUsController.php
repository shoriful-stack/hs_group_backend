<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\Http\Controllers\API\V1\HomePageController;
use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class AboutUsController extends Controller
{
    public function index()
    {
        $data = AboutUs::query()->where('branch_id', Auth::user()->branch_id)->firstOrNew();
        return view('about_us.index', compact('data'));
    }

    public function store(AboutUsRequest $request)
    {
        $data = AboutUs::query()
            ->where('branch_id', Auth::user()->branch_id)
            ->first();

        $images = $this->resolveCollageImages($request, $data);

        $payload = [
            'language_id' => $request->language_id ?? 1,
            'type'        => 1,
            'title'       => $request->title,
            'content'     => $request->contents,
            'image'       => $images[0] ?? null,
            'serial_no'   => $request->serial_no ?? 1,
            'status'      => 1,
        ];

        if (Schema::hasColumn('about_us', 'images')) {
            $payload['images'] = $images;
        }

        AboutUs::updateOrCreate(
            ['branch_id' => Auth::user()->branch_id],
            $payload
        );

        Cache::forget('about_us');
        HomePageController::forgetCache();

        return ReturnMessage::updateSuccess();
    }

    /**
     * @return list<string>
     */
    private function resolveCollageImages(AboutUsRequest $request, ?AboutUs $data): array
    {
        $existing = [];
        if (is_array($data?->images)) {
            $existing = array_values(array_filter($data->images, fn ($path) => is_string($path) && $path !== ''));
        } elseif (! empty($data?->image)) {
            $existing = [$data->image];
        }

        $images = [];

        for ($i = 0; $i < 4; $i++) {
            $file = $request->file("images.$i");
            if ($file instanceof UploadedFile) {
                $images[$i] = Helper::imageUpload(
                    $file,
                    'about_us_' . uniqid(),
                    'about_us',
                    $existing[$i] ?? null
                );
                continue;
            }

            if (! empty($existing[$i]) && is_string($existing[$i])) {
                $images[$i] = $existing[$i];
            }
        }

        return array_values(array_filter($images, fn ($path) => is_string($path) && $path !== ''));
    }
}
