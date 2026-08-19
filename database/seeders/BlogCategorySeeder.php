<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Company News',
            'Projects',
            'Press Release',
            'CSR',
            'Awards',
            'Events',
            'Media',
        ];

        foreach ($categories as $i => $name) {
            BlogCategory::withoutEvents(function () use ($name, $i) {
                BlogCategory::withoutGlobalScopes()->updateOrCreate(
                    [
                        'slug'      => Str::slug($name),
                        'branch_id' => 1,
                    ],
                    [
                        'name'        => $name,
                        'language_id' => 1,
                        'serial_no'   => $i + 1,
                        'status'      => 1,
                    ]
                );
            });
        }
    }
}
