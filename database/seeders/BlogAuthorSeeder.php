<?php

namespace Database\Seeders;

use App\Models\BlogAuthor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogAuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name'        => 'HS Group Communications',
                'designation' => 'Corporate Communications Lead',
                'department'  => 'Corporate Affairs',
                'bio'         => 'Responsible for enterprise communications, press relations, and editorial storytelling across HS Group’s engineering portfolio.',
                'email'       => 'media@hsgroup.com',
            ],
            [
                'name'        => 'Engineering Desk',
                'designation' => 'Senior Engineering Editor',
                'department'  => 'Technical Communications',
                'bio'         => 'Covers project delivery, digital infrastructure, and field engineering practices across power, telecom, and industrial programs.',
                'email'       => 'engineering@hsgroup.com',
            ],
            [
                'name'        => 'Energy Desk',
                'designation' => 'Renewable Energy Correspondent',
                'department'  => 'Power & Utilities',
                'bio'         => 'Reports on solar, substation, and grid modernization programs supporting industrial and utility clients.',
                'email'       => 'energy@hsgroup.com',
            ],
            [
                'name'        => 'Corporate Affairs',
                'designation' => 'Press & Public Affairs Manager',
                'department'  => 'Corporate Affairs',
                'bio'         => 'Leads official announcements, milestone communications, and stakeholder engagement for HS Group.',
                'email'       => 'corporate@hsgroup.com',
            ],
            [
                'name'        => 'CSR Office',
                'designation' => 'Community Impact Lead',
                'department'  => 'CSR & Sustainability',
                'bio'         => 'Develops community skills programs and social value initiatives aligned with responsible engineering growth.',
                'email'       => 'csr@hsgroup.com',
            ],
            [
                'name'        => 'Media Desk',
                'designation' => 'Media Relations Specialist',
                'department'  => 'Corporate Communications',
                'bio'         => 'Produces media features, event coverage, and visual storytelling from HS Group project sites and forums.',
                'email'       => 'press@hsgroup.com',
            ],
        ];

        foreach ($authors as $i => $author) {
            BlogAuthor::withoutEvents(function () use ($author, $i) {
                BlogAuthor::withoutGlobalScopes()->updateOrCreate(
                    [
                        'slug'      => Str::slug($author['name']),
                        'branch_id' => 1,
                    ],
                    [
                        'name'        => $author['name'],
                        'designation' => $author['designation'],
                        'department'  => $author['department'],
                        'bio'         => $author['bio'],
                        'email'       => $author['email'],
                        'language_id' => 1,
                        'serial_no'   => $i + 1,
                        'status'      => 1,
                    ]
                );
            });
        }
    }
}
