<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;
use App\Models\MenuTranslation;
use App\Models\MenuDisplaySetting;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data
        MenuDisplaySetting::truncate();
        MenuTranslation::truncate();
        MenuCategory::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Main menu items
        $mainMenuItems = [
            [
                'sort_order' => 1,
                'translations' => [
                    ['language_code' => 'th', 'name' => 'หน้าแรก', 'url' => 'https://www.fitm.kmutnb.ac.th/'],
                    ['language_code' => 'en', 'name' => 'Home', 'url' => 'https://www.fitm.kmutnb.ac.th/']
                ],
                'display' => ['show_dropdown' => false]
            ],
            [
                'sort_order' => 2,
                'translations' => [
                    ['language_code' => 'th', 'name' => 'เกี่ยวกับ คณะฯ', 'url' => 'https://www.fitm.kmutnb.ac.th/about.aspx'],
                    ['language_code' => 'en', 'name' => 'About Faculty', 'url' => 'https://www.fitm.kmutnb.ac.th/about.aspx']
                ],
                'display' => ['show_dropdown' => true],
                'children' => [
                    [
                        'sort_order' => 1,
                        'translations' => [
                            ['language_code' => 'th', 'name' => 'ประวัติ', 'url' => 'https://www.fitm.kmutnb.ac.th/history.html'],
                            ['language_code' => 'en', 'name' => 'History', 'url' => 'https://www.fitm.kmutnb.ac.th/history.html']
                        ],
                        'display' => ['show_dropdown' => false]
                    ],
                    [
                        'sort_order' => 2,
                        'translations' => [
                            ['language_code' => 'th', 'name' => 'สัญลักษณ์', 'url' => 'https://www.fitm.kmutnb.ac.th/symbols.html'],
                            ['language_code' => 'en', 'name' => 'Symbols', 'url' => 'https://www.fitm.kmutnb.ac.th/symbols.html']
                        ],
                        'display' => ['show_dropdown' => false]
                    ],
                    [
                        'sort_order' => 3,
                        'translations' => [
                            ['language_code' => 'th', 'name' => 'ปณิธาน/วิสัยทัศน์/พันธกิจ', 'url' => 'https://www.fitm.kmutnb.ac.th/philosophy.html'],
                            ['language_code' => 'en', 'name' => 'Vision/Mission', 'url' => 'https://www.fitm.kmutnb.ac.th/philosophy.html']
                        ],
                        'display' => ['show_dropdown' => false]
                    ]
                ]
            ]
        ];

        foreach ($mainMenuItems as $item) {
            $this->createMenuItem($item);
        }
    }

    private function createMenuItem($itemData, $parentId = null)
    {
        // Create menu category
        $category = MenuCategory::create([
            'parent_id' => $parentId,
            'sort_order' => $itemData['sort_order'],
            'is_active' => true,
        ]);

        // Create translations
        foreach ($itemData['translations'] as $translation) {
            $category->translations()->create($translation);
        }

        // Create display settings
        $category->displaySetting()->create(array_merge(
            [
                'is_visible' => true,
                'css_class' => isset($parentId) ? 'CMSListMenuLI' : null,
            ],
            $itemData['display'] ?? []
        ));

        // Create children if any
        if (isset($itemData['children'])) {
            foreach ($itemData['children'] as $child) {
                $this->createMenuItem($child, $category->id);
            }
        }

        return $category;
    }
}
