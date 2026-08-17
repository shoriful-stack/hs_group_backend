<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class HomePageController
{
    public const CACHE_KEY = 'home_static_data';
    public const CACHE_TTL = 86400;

    public function staticData()
    {
        $payload = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $aboutRows = $this->safeCollect(function () {
                return DB::table('about_us')
                    ->whereNull('deleted_at')
                    ->where('status', 1)
                    ->orderBy('serial_no')
                    ->select('id', 'title', 'content', 'image', 'serial_no')
                    ->get();
            });

            $about = $aboutRows->first();
            $images = $aboutRows
                ->pluck('image')
                ->filter()
                ->values()
                ->all();

            $chooseUs = $this->safeFirst(function () {
                return DB::table('choose_us')
                    ->whereNull('deleted_at')
                    ->select('title', 'content', 'image', 'features')
                    ->first();
            });

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
                    'url'         => $row->url,
                    'serial_no'   => (int) $row->serial_no,
                ])->values()->all(),

                'about_stats' => [
                    'title'   => $about->title ?? null,
                    'content' => $about->content ?? null,
                    'image'   => $about->image ?? null,
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

                'features' => $this->mapFeatures($chooseUs->features ?? null),

                'partners' => $this->safeCollect(function () {
                    return DB::table('brands')
                        ->whereNull('deleted_at')
                        ->where('status', 1)
                        ->select('id', 'title', 'image', 'content')
                        ->get();
                })->map(fn ($row) => [
                    'id'      => $row->id,
                    'name'    => $row->title,
                    'logo'    => $row->image,
                    'content' => $row->content,
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
     * @return list<array{icon: ?string, title: string, short_description: ?string}>
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

                return [
                    'icon'              => isset($item['icon']) ? (string) $item['icon'] : null,
                    'title'             => $title,
                    'short_description' => is_string($description) ? $description : null,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
