<?php

namespace App\Services;

use App\Enums\Status;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class LayoutDataService
{
    public const CACHE_KEY = 'layout_data_v1';
    public const CACHE_TTL = 3600;

    public const LATEST_PRODUCTS_LIMIT = 6;
    public const CATEGORY_LIMIT = 5;

    public function get(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'general_settings' => $this->generalSettings(),
                'contact_us'       => $this->contact(),
                'social_links'     => $this->socialLinks(),
                'navigation'       => [
                    'latest_products'    => $this->latestProducts(),
                    'product_categories' => $this->productCategories(),
                    'service_categories' => $this->serviceCategories(),
                ],
            ];
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function generalSettings(): ?array
    {
        $row = $this->safeFirst(function () {
            return DB::table('general_settings')
                ->select('id', 'title', 'favicon', 'logo_header', 'logo_footer', 'description', 'keywords')
                ->first();
        });

        if (! $row) {
            return null;
        }

        return [
            'id'          => $row->id,
            'title'       => $row->title,
            'favicon'     => $row->favicon,
            'logo_header' => $row->logo_header,
            'logo_footer' => $row->logo_footer,
            'description' => $row->description,
            'keywords'    => $row->keywords,
        ];
    }

    private function contact(): ?array
    {
        $row = $this->safeCollect(function () {
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

        if (! $row) {
            return null;
        }

        return [
            'id'              => $row->id,
            'address'         => $row->address,
            'primary_phone'   => $row->primary_phone,
            'secondary_phone' => $row->secondary_phone,
            'primary_email'   => $row->primary_email,
            'secondary_email' => $row->secondary_email,
            'whatsapp_number' => $row->whatsapp_number,
        ];
    }

    /**
     * @return list<array{id: int, icon: mixed, link: mixed}>
     */
    private function socialLinks(): array
    {
        return $this->safeCollect(function () {
            return DB::table('social_links')->select('id', 'icon', 'link')->get();
        })->map(fn ($row) => [
            'id'   => $row->id,
            'icon' => $row->icon,
            'link' => $row->link,
        ])->values()->all();
    }

    /**
     * @return list<array{id: int, title: string, slug: string}>
     */
    private function latestProducts(): array
    {
        return $this->safeCollect(function () {
            $query = DB::table('products')
                ->select('id', 'title', 'slug')
                ->where('status', Status::ACTIVE->value)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->whereNotNull('title')
                ->where('title', '!=', '')
                ->orderByDesc('id')
                ->limit(self::LATEST_PRODUCTS_LIMIT);

            if (Schema::hasColumn('products', 'deleted_at')) {
                $query->whereNull('deleted_at');
            }

            return $query->get();
        })->map(fn ($row) => [
            'id'    => (int) $row->id,
            'title' => (string) $row->title,
            'slug'  => (string) $row->slug,
        ])->values()->all();
    }

    /**
     * @return list<array{id: int, name: string, slug: string}>
     */
    private function productCategories(): array
    {
        return $this->mapCategories(
            'product_categories',
            fn ($query) => Schema::hasColumn('product_categories', 'parent_id')
                ? $query->whereNull('parent_id')
                : $query
        );
    }

    /**
     * @return list<array{id: int, name: string, slug: string}>
     */
    private function serviceCategories(): array
    {
        return $this->mapCategories('service_categories');
    }

    /**
     * @param  callable(\Illuminate\Database\Query\Builder): \Illuminate\Database\Query\Builder|null  $tap
     * @return list<array{id: int, name: string, slug: string}>
     */
    private function mapCategories(string $table, ?callable $tap = null): array
    {
        return $this->safeCollect(function () use ($table, $tap) {
            $query = DB::table($table)
                ->select('id', 'name', 'slug')
                ->where('status', Status::ACTIVE->value)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->whereNotNull('name')
                ->where('name', '!=', '')
                ->orderBy('id')
                ->limit(self::CATEGORY_LIMIT);

            if (Schema::hasColumn($table, 'deleted_at')) {
                $query->whereNull('deleted_at');
            }

            if ($tap) {
                $query = $tap($query);
            }

            return $query->get();
        })->map(fn ($row) => [
            'id'   => (int) $row->id,
            'name' => (string) $row->name,
            'slug' => (string) $row->slug,
        ])->values()->all();
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
}
