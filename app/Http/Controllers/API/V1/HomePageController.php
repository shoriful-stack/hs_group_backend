<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class HomePageController
{
    public const CACHE_KEY = 'home_static_data_v3';
    public const CACHE_TTL = 86400;

    public function staticData()
    {
        $payload = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $aboutRows = $this->safeCollect(function () {
                $columns = ['id', 'title', 'content', 'image', 'serial_no'];
                if (Schema::hasColumn('about_us', 'images')) {
                    $columns[] = 'images';
                }

                return DB::table('about_us')
                    ->whereNull('deleted_at')
                    ->where('status', 1)
                    ->orderBy('serial_no')
                    ->select($columns)
                    ->get();
            });

            $about = $aboutRows->first();
            $images = $this->collageImages($about, $aboutRows);

            $chooseUs = $this->safeFirst(function () {
                return DB::table('choose_us')
                    ->whereNull('deleted_at')
                    ->select('title', 'content', 'image', 'features')
                    ->first();
            });

            $settings = $this->safeFirst(function () {
                return DB::table('general_settings')
                    ->select(
                        'id',
                        'title',
                        'favicon',
                        'logo_header',
                        'logo_footer',
                        'description',
                        'keywords'
                    )
                    ->first();
            });

            $contact = $this->safeCollect(function () {
                return DB::table('contact_us')
                    ->select(
                        'id',
                        'address',
                        'primary_phone',
                        'secondary_phone',
                        'primary_email',
                        'secondary_email',
                        'whatsapp_number'
                    )
                    ->get();
            })->first();

            return [
                'hero' => $this->safeCollect(function () {
                    return DB::table('sliders')
                        ->whereNull('deleted_at')
                        ->where('status', 1)
                        ->orderBy('serial_no')
                        ->select(
                            'id',
                            'title',
                            'content',
                            'sub_title',
                            'sub_content',
                            'image',
                            'video',
                            'url',
                            'serial_no'
                        )
                        ->get();
                })->map(fn ($row) => [
                    'id'          => $row->id,
                    'title'       => $row->title,
                    'content'     => $row->content,
                    'sub_title'   => $row->sub_title,
                    'sub_content' => $row->sub_content,
                    'image'       => $row->image,
                    'video'       => $row->video ?? null,
                    'url'         => $row->url,
                    'serial_no'   => (int) $row->serial_no,
                ])->values()->all(),

                'about_stats' => [
                    'title'   => $about?->title ?? null,
                    'content' => $about?->content ?? null,
                    'image'   => $about?->image ?? null,
                    'images'  => $images,
                    'stats'   => $this->safeCollect(function () {
                        return DB::table('stats')
                            ->whereNull('deleted_at')
                            ->where('status', 1)
                            ->orderBy('serial_no')
                            ->select('id', 'title', 'value', 'serial_no')
                            ->get();
                    })->map(fn ($row) => [
                        'id'        => $row->id,
                        'title'     => $row->title,
                        'value'     => $row->value,
                        'serial_no' => (int) $row->serial_no,
                    ])->values()->all(),
                ],

                'features' => $this->mapFeatures($chooseUs?->features ?? null),

                'partners' => $this->safeCollect(function () {
                    return DB::table('our_customers')
                        ->whereNull('deleted_at')
                        ->where('status', 1)
                        ->select('id', 'title', 'image', 'content')
                        ->get();
                })->map(fn ($row) => [
                    'id'      => $row->id ?? null,
                    'name'    => $row->title ?? null,
                    'logo'    => $row->image ?? null,
                    'content' => $row->content ?? null,
                ])->filter(fn ($row) => is_string($row['name']) && $row['name'] !== '')
                    ->values()
                    ->all(),

                'general_settings' => $settings ? [
                    'id'          => $settings->id,
                    'title'       => $settings->title,
                    'favicon'     => $settings->favicon,
                    'logo_header' => $settings->logo_header,
                    'logo_footer' => $settings->logo_footer,
                    'description' => $settings->description,
                    'keywords'    => $settings->keywords,
                ] : null,

                'contact_us' => $contact ? [
                    'id'               => $contact->id,
                    'address'          => $contact->address,
                    'primary_phone'    => $contact->primary_phone,
                    'secondary_phone'  => $contact->secondary_phone,
                    'primary_email'    => $contact->primary_email,
                    'secondary_email'  => $contact->secondary_email,
                    'whatsapp_number'  => $contact->whatsapp_number,
                ] : null,

                'social_links' => $this->safeCollect(function () {
                    return DB::table('social_links')
                        ->select('id', 'icon', 'link')
                        ->get();
                })->map(fn ($row) => [
                    'id'   => $row->id,
                    'icon' => $row->icon,
                    'link' => $row->link,
                ])->values()->all(),
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $payload,
        ], 200);
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @return \Illuminate\Support\Collection<int, object>
     */
    private function safeCollect(callable $callback)
    {
        try {
            return collect($callback() ?? []);
        } catch (Throwable) {
            return collect();
        }
    }

    private function safeFirst(callable $callback): ?object
    {
        try {
            $row = $callback();

            return is_object($row) ? $row : null;
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param  \Illuminate\Support\Collection<int, object>  $aboutRows
     * @return list<string>
     */
    private function collageImages(?object $about, $aboutRows): array
    {
        $fromJson = $this->decodeImageList($about?->images ?? null);
        if ($fromJson !== []) {
            return $fromJson;
        }

        return $aboutRows
            ->pluck('image')
            ->filter(fn ($path) => is_string($path) && $path !== '')
            ->unique()
            ->take(4)
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function decodeImageList(mixed $value): array
    {
        if (is_string($value) && $value !== '') {
            $value = json_decode($value, true);
        }

        if (! is_array($value)) {
            return [];
        }

        return collect($value)
            ->filter(fn ($path) => is_string($path) && $path !== '')
            ->unique()
            ->take(4)
            ->values()
            ->all();
    }

    /**
     * @return list<array{icon: ?string, title: string, short_description: ?string, image: ?string}>
     */
    private function mapFeatures(mixed $raw): array
    {
        $decoded = $raw;

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
        }

        if (! is_array($decoded)) {
            return [];
        }

        return collect($decoded)
            ->map(function ($item) {
                if (! is_array($item)) {
                    return null;
                }

                $title = trim((string) ($item['title'] ?? ''));
                if ($title === '') {
                    return null;
                }

                $description = $item['short_description'] ?? $item['description'] ?? null;
                $image = $item['image'] ?? null;

                return [
                    'icon'              => isset($item['icon']) ? (string) $item['icon'] : null,
                    'title'             => $title,
                    'short_description' => is_string($description) ? $description : null,
                    'image'             => is_string($image) && $image !== '' ? $image : null,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
