<?php

namespace Database\Seeders;

use App\Models\NewsEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsEventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title'      => 'South Asia Infrastructure Summit',
                'event_date' => '2026-09-18',
                'location'   => 'Dhaka, Bangladesh',
                'image'      => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200&q=85&auto=format&fit=crop',
                'cta_label'  => 'Register Interest',
                'cta_href'   => '/contact',
            ],
            [
                'title'      => 'Renewable Energy & Grid Forum',
                'event_date' => '2026-11-04',
                'location'   => 'Singapore',
                'image'      => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=1200&q=85&auto=format&fit=crop',
                'cta_label'  => 'Register Interest',
                'cta_href'   => '/contact',
            ],
            [
                'title'      => 'Engineering Excellence Showcase 2025',
                'event_date' => '2025-05-12',
                'location'   => 'Dhaka, Bangladesh',
                'image'      => 'https://images.unsplash.com/photo-1591115765373-5207764f72e7?w=1200&q=85&auto=format&fit=crop',
                'cta_label'  => 'View Coverage',
                'cta_href'   => '/blog',
            ],
            [
                'title'      => 'Telecom Infrastructure Roundtable',
                'event_date' => '2025-02-20',
                'location'   => 'Colombo, Sri Lanka',
                'image'      => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1200&q=85&auto=format&fit=crop',
                'cta_label'  => 'View Coverage',
                'cta_href'   => '/blog',
            ],
        ];

        foreach ($events as $i => $event) {
            NewsEvent::withoutEvents(function () use ($event, $i) {
                NewsEvent::withoutGlobalScopes()->updateOrCreate(
                    [
                        'slug'      => Str::slug($event['title']),
                        'branch_id' => 1,
                    ],
                    [
                        'title'       => $event['title'],
                        'event_date'  => $event['event_date'],
                        'location'    => $event['location'],
                        'image'       => $event['image'],
                        'cta_label'   => $event['cta_label'],
                        'cta_href'    => $event['cta_href'],
                        'language_id' => 1,
                        'serial_no'   => $i + 1,
                        'status'      => 1,
                    ]
                );
            });
        }
    }
}
