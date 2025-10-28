<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Task;
use App\Models\TaskChecklistItem;
use App\Models\Recipe;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Locations with QR payloads
        $locations = [
            ['name' => 'Restroom',  'slug' => 'restroom',  'qrcode_payload' => 'BLUEMOON:LOC:RESTROOM'],
            ['name' => 'Stockroom', 'slug' => 'stockroom', 'qrcode_payload' => 'BLUEMOON:LOC:STOCKROOM'],
            ['name' => 'Kitchen',   'slug' => 'kitchen',   'qrcode_payload' => 'BLUEMOON:LOC:KITCHEN'],
        ];
        foreach ($locations as $loc) {
            Location::updateOrCreate(['slug' => $loc['slug']], $loc);
        }

        // Opening tasks
        $openTasks = [
            [
                'title' => 'Open Cash Drawer', 'location' => 'stockroom', 'items' => [
                    'Count starting cash', 'Record digital wallet balance', 'Verify bank slip'
                ]
            ],
            [
                'title' => 'Prep Kitchen', 'location' => 'kitchen', 'items' => [
                    'Turn on machines', 'Sanitize counters', 'Stock ingredients'
                ]
            ],
        ];

        // Closing tasks
        $closeTasks = [
            [
                'title' => 'Close Cash Drawer', 'location' => 'stockroom', 'items' => [
                    'Count turnover cash', 'Record digital wallet balance', 'Deposit to bank'
                ]
            ],
            [
                'title' => 'Clean Restroom', 'location' => 'restroom', 'items' => [
                    'Restock tissue', 'Mop floor', 'Disinfect surfaces'
                ]
            ],
        ];

        $orderItems = function(array $labels) {
            $out = [];
            foreach ($labels as $i => $label) {
                $out[] = ['label' => $label, 'display_order' => $i + 1];
            }
            return $out;
        };

        foreach ($openTasks as $t) {
            $loc = Location::where('slug', $t['location'])->first();
            $task = Task::updateOrCreate(
                ['title' => $t['title'], 'type' => 'opening'],
                ['location_id' => $loc?->id, 'active' => true]
            );
            foreach ($orderItems($t['items']) as $item) {
                TaskChecklistItem::updateOrCreate(
                    ['task_id' => $task->id, 'label' => $item['label']],
                    ['display_order' => $item['display_order']]
                );
            }
        }

        foreach ($closeTasks as $t) {
            $loc = Location::where('slug', $t['location'])->first();
            $task = Task::updateOrCreate(
                ['title' => $t['title'], 'type' => 'closing'],
                ['location_id' => $loc?->id, 'active' => true]
            );
            foreach ($orderItems($t['items']) as $item) {
                TaskChecklistItem::updateOrCreate(
                    ['task_id' => $task->id, 'label' => $item['label']],
                    ['display_order' => $item['display_order']]
                );
            }
        }

        // Recipes
        $recipes = [
            [
                'title' => 'Iced Latte',
                'thumbnail_path' => null,
                'video_url' => 'https://example.com/videos/iced-latte.mp4',
                'description' => 'Prepare a classic iced latte.',
                'duration_sec' => 120,
            ],
            [
                'title' => 'Caramel Macchiato',
                'thumbnail_path' => null,
                'video_url' => 'https://example.com/videos/caramel-macchiato.mp4',
                'description' => 'Layered caramel macchiato training.',
                'duration_sec' => 150,
            ],
        ];
        foreach ($recipes as $rec) {
            Recipe::updateOrCreate(['title' => $rec['title']], $rec);
        }
    }
}
