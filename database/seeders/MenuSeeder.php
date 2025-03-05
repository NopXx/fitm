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
        try {
            // Manually disable foreign key constraints for each table
            // SQL Server specific syntax
            DB::statement('ALTER TABLE [menu_display_settings] NOCHECK CONSTRAINT ALL');
            DB::statement('ALTER TABLE [menu_translations] NOCHECK CONSTRAINT ALL');
            DB::statement('ALTER TABLE [menu_categories] NOCHECK CONSTRAINT ALL');

            // Clear existing data - use delete instead of truncate for better control
            DB::table('menu_display_settings')->delete();
            DB::table('menu_translations')->delete();
            DB::table('menu_categories')->delete();

            // Main menu items
            $mainMenuItems = [
                [
                    'sort_order' => 1,
                    'translations' => [
                        ['language_code' => 'th', 'name' => 'หน้าแรก', 'url' => ''],
                        ['language_code' => 'en', 'name' => 'Home', 'url' => '']
                    ],
                    'display' => ['show_dropdown' => false]
                ],
                [
                    'sort_order' => 2,
                    'translations' => [
                        ['language_code' => 'th', 'name' => 'เกี่ยวกับ คณะฯ', 'url' => ''],
                        ['language_code' => 'en', 'name' => 'About Faculty', 'url' => '']
                    ],
                    'display' => ['show_dropdown' => true],
                    'children' => [
                        [
                            'sort_order' => 1,
                            'translations' => [
                                ['language_code' => 'th', 'name' => 'ประวัติ', 'url' => '/history'],
                                ['language_code' => 'en', 'name' => 'History', 'url' => '/history']
                            ],
                            'display' => ['show_dropdown' => false]
                        ],
                        [
                            'sort_order' => 2,
                            'translations' => [
                                ['language_code' => 'th', 'name' => 'สัญลักษณ์', 'url' => '/symbols'],
                                ['language_code' => 'en', 'name' => 'Symbols', 'url' => '/symbols']
                            ],
                            'display' => ['show_dropdown' => false]
                        ],
                        [
                            'sort_order' => 3,
                            'translations' => [
                                ['language_code' => 'th', 'name' => 'ปณิธาน/วิสัยทัศน์/พันธกิจ', 'url' => '/philosophy'],
                                ['language_code' => 'en', 'name' => 'Vision/Mission', 'url' => '/philosophy']
                            ],
                            'display' => ['show_dropdown' => false]
                        ]
                    ]
                ]
            ];

            foreach ($mainMenuItems as $item) {
                $this->createMenuItem($item);
            }

            // Re-enable constraints
            DB::statement('ALTER TABLE [menu_categories] WITH CHECK CHECK CONSTRAINT ALL');
            DB::statement('ALTER TABLE [menu_translations] WITH CHECK CHECK CONSTRAINT ALL');
            DB::statement('ALTER TABLE [menu_display_settings] WITH CHECK CHECK CONSTRAINT ALL');

        } catch (\Exception $e) {
            // Make sure to re-enable constraints even if there's an error
            DB::statement('ALTER TABLE [menu_categories] WITH CHECK CHECK CONSTRAINT ALL');
            DB::statement('ALTER TABLE [menu_translations] WITH CHECK CHECK CONSTRAINT ALL');
            DB::statement('ALTER TABLE [menu_display_settings] WITH CHECK CHECK CONSTRAINT ALL');

            throw $e;
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
