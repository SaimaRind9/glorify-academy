<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NurseryActivityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'activity_name' => 'English',
                'display_order' => 1,
                'status' => true,
            ],
            [
                'activity_name' => 'Math',
                'display_order' => 2,
                'status' => true,
            ],
            [
                'activity_name' => 'Drawing',
                'display_order' => 3,
                'status' => true,
            ],
            [
                'activity_name' => 'Writing',
                'display_order' => 4,
                'status' => true,
            ],
            [
                'activity_name' => 'Reading',
                'display_order' => 5,
                'status' => true,
            ],
            [
                'activity_name' => 'Behaviour',
                'display_order' => 6,
                'status' => true,
            ],
            [
                'activity_name' => 'Confidence',
                'display_order' => 7,
                'status' => true,
            ],
            [
                'activity_name' => 'Participation',
                'display_order' => 8,
                'status' => true,
            ],
            [
                'activity_name' => 'Cleanliness',
                'display_order' => 9,
                'status' => true,
            ],
        ];

        foreach ($activities as $activity) {
            DB::table('nursery_activity_types')->updateOrInsert(
                [
                    'activity_name' => $activity['activity_name'],
                ],
                [
                    'display_order' => $activity['display_order'],
                    'status' => $activity['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}