<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        Schema::disableForeignKeyConstraints();

        // Clear existing menu data
        DB::table('menu_translations')->truncate();
        DB::table('menu_display_settings')->truncate();
        DB::table('menu_categories')->truncate();

        // Seed menu categories
        $this->seedMenuCategories();

        // Seed menu display settings
        $this->seedMenuDisplaySettings();

        // Seed menu translations
        $this->seedMenuTranslations();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Seed the menu_categories table
     */
    private function seedMenuCategories(): void
    {
        $menuCategories = [
            [
                'id' => 1,
                'system_name' => NULL,
                'parent_id' => NULL,
                'sort_order' => 0,
                'is_active' => 0,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-04-22 06:51:40'
            ],
            [
                'id' => 2,
                'system_name' => NULL,
                'parent_id' => NULL,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-04-22 06:51:40'
            ],
            [
                'id' => 3,
                'system_name' => NULL,
                'parent_id' => 2,
                'sort_order' => 0,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-27 13:33:20'
            ],
            [
                'id' => 4,
                'system_name' => NULL,
                'parent_id' => 2,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-27 13:33:20'
            ],
            [
                'id' => 5,
                'system_name' => NULL,
                'parent_id' => 2,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-27 13:33:20'
            ],
            [
                'id' => 6,
                'system_name' => 'departments',
                'parent_id' => NULL,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-22 06:51:40'
            ],
            [
                'id' => 7,
                'system_name' => 'dept_IT',
                'parent_id' => 6,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 8,
                'system_name' => 'dept_IM',
                'parent_id' => 6,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 9,
                'system_name' => 'dept_CDM',
                'parent_id' => 6,
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 10,
                'system_name' => 'dept_AEI',
                'parent_id' => 6,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 11,
                'system_name' => 'dept_Office',
                'parent_id' => 6,
                'sort_order' => 5,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-25 09:03:14'
            ],
            [
                'id' => 12,
                'system_name' => NULL,
                'parent_id' => 25,
                'sort_order' => 5,
                'is_active' => 1,
                'created_at' => '2025-02-17 17:52:48',
                'updated_at' => '2025-03-11 13:25:14'
            ],
            [
                'id' => 13,
                'system_name' => NULL,
                'parent_id' => NULL,
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2025-02-21 14:27:08',
                'updated_at' => '2025-04-22 06:51:40'
            ],
            [
                'id' => 14,
                'system_name' => NULL,
                'parent_id' => 13,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2025-02-21 14:28:19',
                'updated_at' => '2025-02-21 15:54:05'
            ],
            [
                'id' => 15,
                'system_name' => NULL,
                'parent_id' => 13,
                'sort_order' => 0,
                'is_active' => 1,
                'created_at' => '2025-02-21 14:29:22',
                'updated_at' => '2025-02-21 15:54:05'
            ],
            [
                'id' => 16,
                'system_name' => NULL,
                'parent_id' => 2,
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2025-02-25 07:57:51',
                'updated_at' => '2025-02-27 13:33:20'
            ],
            [
                'id' => 19,
                'system_name' => NULL,
                'parent_id' => 2,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => '2025-03-11 08:12:14',
                'updated_at' => '2025-03-11 08:12:14'
            ],
            [
                'id' => 20,
                'system_name' => NULL,
                'parent_id' => NULL,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => '2025-03-11 12:39:15',
                'updated_at' => '2025-04-22 06:51:40'
            ],
            [
                'id' => 21,
                'system_name' => NULL,
                'parent_id' => 20,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2025-03-11 12:40:20',
                'updated_at' => '2025-03-11 12:40:20'
            ],
            [
                'id' => 22,
                'system_name' => NULL,
                'parent_id' => 20,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2025-03-11 12:41:00',
                'updated_at' => '2025-03-11 12:41:00'
            ],
            [
                'id' => 23,
                'system_name' => NULL,
                'parent_id' => 20,
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2025-03-11 12:41:39',
                'updated_at' => '2025-03-11 12:41:39'
            ],
            [
                'id' => 24,
                'system_name' => NULL,
                'parent_id' => 20,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => '2025-03-11 12:45:21',
                'updated_at' => '2025-03-11 12:45:21'
            ],
            [
                'id' => 25,
                'system_name' => NULL,
                'parent_id' => NULL,
                'sort_order' => 5,
                'is_active' => 1,
                'created_at' => '2025-03-11 13:25:02',
                'updated_at' => '2025-04-22 06:51:40'
            ],
            [
                'id' => 26,
                'system_name' => NULL,
                'parent_id' => 25,
                'sort_order' => 6,
                'is_active' => 1,
                'created_at' => '2025-03-11 13:26:05',
                'updated_at' => '2025-03-11 13:26:05'
            ],
            [
                'id' => 27,
                'system_name' => NULL,
                'parent_id' => 25,
                'sort_order' => 7,
                'is_active' => 1,
                'created_at' => '2025-04-22 07:01:26',
                'updated_at' => '2025-04-22 07:01:26'
            ],
        ];

        DB::table('menu_categories')->insert($menuCategories);
    }

    /**
     * Seed the menu_display_settings table
     */
    private function seedMenuDisplaySettings(): void
    {
        $menuDisplaySettings = [
            [
                'id' => 1,
                'category_id' => 1,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-27 13:33:25'
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'is_visible' => 1,
                'show_dropdown' => 1,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-17 17:44:16'
            ],
            [
                'id' => 3,
                'category_id' => 3,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => 'CMSListMenuLI',
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-17 17:44:16'
            ],
            [
                'id' => 4,
                'category_id' => 4,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => 'CMSListMenuLI',
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-17 17:44:16'
            ],
            [
                'id' => 5,
                'category_id' => 5,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => 'CMSListMenuLI',
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-17 17:44:16'
            ],
            [
                'id' => 6,
                'category_id' => 6,
                'is_visible' => 1,
                'show_dropdown' => 1,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 7,
                'category_id' => 7,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 8,
                'category_id' => 8,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 9,
                'category_id' => 9,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 10,
                'category_id' => 10,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 11,
                'category_id' => 11,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 12,
                'category_id' => 12,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-17 17:52:48',
                'updated_at' => '2025-02-17 17:52:48'
            ],
            [
                'id' => 13,
                'category_id' => 13,
                'is_visible' => 1,
                'show_dropdown' => 1,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-21 14:27:08',
                'updated_at' => '2025-02-21 14:27:08'
            ],
            [
                'id' => 14,
                'category_id' => 14,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-21 14:28:19',
                'updated_at' => '2025-02-21 14:28:19'
            ],
            [
                'id' => 15,
                'category_id' => 15,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-21 14:29:22',
                'updated_at' => '2025-02-21 14:29:22'
            ],
            [
                'id' => 16,
                'category_id' => 16,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-02-25 07:57:51',
                'updated_at' => '2025-02-25 07:57:51'
            ],
            [
                'id' => 19,
                'category_id' => 19,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 08:12:14',
                'updated_at' => '2025-03-11 08:12:14'
            ],
            [
                'id' => 20,
                'category_id' => 20,
                'is_visible' => 1,
                'show_dropdown' => 1,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 12:39:15',
                'updated_at' => '2025-03-11 12:39:15'
            ],
            [
                'id' => 21,
                'category_id' => 21,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 12:40:20',
                'updated_at' => '2025-03-11 12:40:20'
            ],
            [
                'id' => 22,
                'category_id' => 22,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 12:41:00',
                'updated_at' => '2025-03-11 12:41:00'
            ],
            [
                'id' => 23,
                'category_id' => 23,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 12:41:39',
                'updated_at' => '2025-03-11 12:41:39'
            ],
            [
                'id' => 24,
                'category_id' => 24,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 12:45:21',
                'updated_at' => '2025-03-11 12:45:21'
            ],
            [
                'id' => 25,
                'category_id' => 25,
                'is_visible' => 1,
                'show_dropdown' => 1,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 13:25:02',
                'updated_at' => '2025-03-11 13:25:02'
            ],
            [
                'id' => 26,
                'category_id' => 26,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-03-11 13:26:05',
                'updated_at' => '2025-03-11 13:26:05'
            ],
            [
                'id' => 27,
                'category_id' => 27,
                'is_visible' => 1,
                'show_dropdown' => 0,
                'css_class' => NULL,
                'icon_url' => NULL,
                'target' => NULL,
                'created_at' => '2025-04-22 07:01:26',
                'updated_at' => '2025-04-22 07:01:26'
            ],
        ];

        DB::table('menu_display_settings')->insert($menuDisplaySettings);
    }

    /**
     * Seed the menu_translations table
     */
    private function seedMenuTranslations(): void
    {
        $menuTranslations = [
            [
                'id' => 1,
                'category_id' => 1,
                'language_code' => 'th',
                'name' => 'หน้าแรก',
                'url' => '/',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-03-11 12:48:29'
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'language_code' => 'en',
                'name' => 'Home',
                'url' => '/',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-03-11 12:48:29'
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'language_code' => 'th',
                'name' => 'เกี่ยวกับ คณะฯ',
                'url' => '#',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 04:40:24'
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'language_code' => 'en',
                'name' => 'About Faculty',
                'url' => '#',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 04:40:24'
            ],
            [
                'id' => 5,
                'category_id' => 3,
                'language_code' => 'th',
                'name' => 'ประวัติ',
                'url' => '/history',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 04:40:49'
            ],
            [
                'id' => 6,
                'category_id' => 3,
                'language_code' => 'en',
                'name' => 'History',
                'url' => '/history',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 04:40:49'
            ],
            [
                'id' => 7,
                'category_id' => 4,
                'language_code' => 'th',
                'name' => 'สัญลักษณ์',
                'url' => '/symbol',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 05:02:25'
            ],
            [
                'id' => 8,
                'category_id' => 4,
                'language_code' => 'en',
                'name' => 'Symbols',
                'url' => '/symbol',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 05:02:25'
            ],
            [
                'id' => 9,
                'category_id' => 5,
                'language_code' => 'th',
                'name' => 'ปณิธาน/วิสัยทัศน์/พันธกิจ',
                'url' => '/contents/philosophy',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 08:12:08'
            ],
            [
                'id' => 10,
                'category_id' => 5,
                'language_code' => 'en',
                'name' => 'Vision/Mission',
                'url' => '/contents/philosophy',
                'created_at' => '2025-02-17 17:44:16',
                'updated_at' => '2025-02-25 08:12:08'
            ],
            [
                'id' => 11,
                'category_id' => 6,
                'language_code' => 'th',
                'name' => 'ภาควิชา/หน่วยงาน',
                'url' => '#',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 12,
                'category_id' => 6,
                'language_code' => 'en',
                'name' => 'Departments',
                'url' => '#',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-02-17 17:44:21'
            ],
            [
                'id' => 13,
                'category_id' => 7,
                'language_code' => 'th',
                'name' => 'ภาควิชาเทคโนโลยีสารสนเทศ(IT)',
                'url' => '/departments/IT',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:36:45'
            ],
            [
                'id' => 14,
                'category_id' => 7,
                'language_code' => 'en',
                'name' => 'Department of Information Technology(IT)',
                'url' => '/departments/IT',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:37:37'
            ],
            [
                'id' => 15,
                'category_id' => 8,
                'language_code' => 'th',
                'name' => 'ภาควิชาการจัดการอุตสาหกรรม(IM)',
                'url' => '/departments/IM',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:36:45'
            ],
            [
                'id' => 16,
                'category_id' => 8,
                'language_code' => 'en',
                'name' => 'Department of Industrial Management(IM)',
                'url' => '/departments/IM',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:37:37'
            ],
            [
                'id' => 17,
                'category_id' => 9,
                'language_code' => 'th',
                'name' => 'ภาควิชาการออกแบบและบริการงานก่อสร้าง(CDM)',
                'url' => '/departments/CDM',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:36:45'
            ],
            [
                'id' => 18,
                'category_id' => 9,
                'language_code' => 'en',
                'name' => 'Department of Design and Construction Management (CDM)',
                'url' => '/departments/CDM',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:37:37'
            ],
            [
                'id' => 19,
                'category_id' => 10,
                'language_code' => 'th',
                'name' => 'ภาควิชาวิศวกรรมเกษตรเพื่ออุตสาหกรรม(AEI)',
                'url' => '/departments/AEI',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:36:45'
            ],
            [
                'id' => 20,
                'category_id' => 10,
                'language_code' => 'en',
                'name' => 'Department of Agricultural Engineering for Industry(AEI)',
                'url' => '/departments/AEI',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:37:37'
            ],
            [
                'id' => 21,
                'category_id' => 11,
                'language_code' => 'th',
                'name' => 'สำนักงานคณบดี(Office)',
                'url' => '/departments/Office',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:36:45'
            ],
            [
                'id' => 22,
                'category_id' => 11,
                'language_code' => 'en',
                'name' => 'Office of the Dean (Office)',
                'url' => '/departments/Office',
                'created_at' => '2025-02-17 17:44:21',
                'updated_at' => '2025-04-21 05:37:37'
            ],
            [
                'id' => 23,
                'category_id' => 12,
                'language_code' => 'th',
                'name' => 'กิจกรรม',
                'url' => '/contents/activity',
                'created_at' => '2025-02-17 17:52:48',
                'updated_at' => '2025-03-11 13:25:14'
            ],
            [
                'id' => 24,
                'category_id' => 12,
                'language_code' => 'en',
                'name' => 'Activity',
                'url' => '/contents/activity',
                'created_at' => '2025-02-17 17:52:48',
                'updated_at' => '2025-03-11 13:25:14'
            ],
            [
                'id' => 25,
                'category_id' => 13,
                'language_code' => 'th',
                'name' => 'รับสมัครนักศึกษา',
                'url' => '#',
                'created_at' => '2025-02-21 14:27:08',
                'updated_at' => '2025-03-11 12:55:02'
            ],
            [
                'id' => 26,
                'category_id' => 13,
                'language_code' => 'en',
                'name' => 'Recruiting students',
                'url' => '#',
                'created_at' => '2025-02-21 14:27:08',
                'updated_at' => '2025-03-11 12:55:02'
            ],
            [
                'id' => 27,
                'category_id' => 14,
                'language_code' => 'th',
                'name' => 'ปวช และปริญญาตรี',
                'url' => 'https://www.admission.kmutnb.ac.th/',
                'created_at' => '2025-02-21 14:28:19',
                'updated_at' => '2025-02-21 14:28:19'
            ],
            [
                'id' => 28,
                'category_id' => 14,
                'language_code' => 'en',
                'name' => 'Vocational certificate and bachelor\'s degree',
                'url' => 'https://www.admission.kmutnb.ac.th/',
                'created_at' => '2025-02-21 14:28:19',
                'updated_at' => '2025-02-21 14:28:19'
            ],
            [
                'id' => 29,
                'category_id' => 15,
                'language_code' => 'th',
                'name' => 'ปริญญาโท',
                'url' => 'https://grad.admission.kmutnb.ac.th/',
                'created_at' => '2025-02-21 14:29:22',
                'updated_at' => '2025-02-21 14:29:34'
            ],
            [
                'id' => 30,
                'category_id' => 15,
                'language_code' => 'en',
                'name' => 'Master\'s degree',
                'url' => 'https://grad.admission.kmutnb.ac.th/',
                'created_at' => '2025-02-21 14:29:22',
                'updated_at' => '2025-02-21 14:29:34'
            ],
            [
                'id' => 31,
                'category_id' => 16,
                'language_code' => 'th',
                'name' => 'วิทยาเขต',
                'url' => '/contents/campus',
                'created_at' => '2025-02-25 07:57:51',
                'updated_at' => '2025-02-25 08:12:18'
            ],
            [
                'id' => 32,
                'category_id' => 16,
                'language_code' => 'en',
                'name' => 'Campus',
                'url' => '/contents/campus',
                'created_at' => '2025-02-25 07:57:51',
                'updated_at' => '2025-02-25 08:12:18'
            ],
            [
                'id' => 37,
                'category_id' => 19,
                'language_code' => 'th',
                'name' => 'บุคลากร',
                'url' => '/personnel',
                'created_at' => '2025-03-11 08:12:14',
                'updated_at' => '2025-03-11 11:54:21'
            ],
            [
                'id' => 38,
                'category_id' => 19,
                'language_code' => 'en',
                'name' => 'Personnel',
                'url' => '/personnel',
                'created_at' => '2025-03-11 08:12:14',
                'updated_at' => '2025-03-11 11:54:21'
            ],
            [
                'id' => 39,
                'category_id' => 20,
                'language_code' => 'th',
                'name' => 'วิจัยและบริการวิชาการ',
                'url' => '#',
                'created_at' => '2025-03-11 12:39:15',
                'updated_at' => '2025-03-11 12:39:15'
            ],
            [
                'id' => 40,
                'category_id' => 20,
                'language_code' => 'en',
                'name' => 'Academic Research',
                'url' => '#',
                'created_at' => '2025-03-11 12:39:15',
                'updated_at' => '2025-03-11 12:39:15'
            ],
            [
                'id' => 41,
                'category_id' => 21,
                'language_code' => 'th',
                'name' => 'ผลงานวิจัยเด่น',
                'url' => 'https://www.kmutnb.ac.th/research-and-academic/outstanding-research.aspx',
                'created_at' => '2025-03-11 12:40:20',
                'updated_at' => '2025-03-11 12:40:20'
            ],
            [
                'id' => 42,
                'category_id' => 21,
                'language_code' => 'en',
                'name' => 'Outstanding research results',
                'url' => 'https://www.kmutnb.ac.th/research-and-academic/outstanding-research.aspx',
                'created_at' => '2025-03-11 12:40:20',
                'updated_at' => '2025-03-11 12:40:20'
            ],
            [
                'id' => 43,
                'category_id' => 22,
                'language_code' => 'th',
                'name' => 'ฐานข้อมูลวิจัย',
                'url' => 'https://research.kmutnb.ac.th/',
                'created_at' => '2025-03-11 12:41:00',
                'updated_at' => '2025-03-11 12:41:00'
            ],
            [
                'id' => 44,
                'category_id' => 22,
                'language_code' => 'en',
                'name' => 'Research database',
                'url' => 'https://research.kmutnb.ac.th/',
                'created_at' => '2025-03-11 12:41:00',
                'updated_at' => '2025-03-11 12:41:00'
            ],
            [
                'id' => 45,
                'category_id' => 23,
                'language_code' => 'th',
                'name' => 'วารสารวิชาการ',
                'url' => 'https://www.kmutnb.ac.th/research-and-academic/journals.aspx',
                'created_at' => '2025-03-11 12:41:39',
                'updated_at' => '2025-03-11 12:41:39'
            ],
            [
                'id' => 46,
                'category_id' => 23,
                'language_code' => 'en',
                'name' => 'Academic journal',
                'url' => 'https://www.kmutnb.ac.th/research-and-academic/journals.aspx',
                'created_at' => '2025-03-11 12:41:39',
                'updated_at' => '2025-03-11 12:41:39'
            ],
            [
                'id' => 47,
                'category_id' => 24,
                'language_code' => 'th',
                'name' => 'บริการวิชาการ',
                'url' => '/contents/academic',
                'created_at' => '2025-03-11 12:45:21',
                'updated_at' => '2025-03-11 12:45:21'
            ],
            [
                'id' => 48,
                'category_id' => 24,
                'language_code' => 'en',
                'name' => 'Academic services',
                'url' => '/contents/academic',
                'created_at' => '2025-03-11 12:45:21',
                'updated_at' => '2025-03-11 12:45:21'
            ],
            [
                'id' => 49,
                'category_id' => 25,
                'language_code' => 'th',
                'name' => 'อื่นๆ',
                'url' => '#',
                'created_at' => '2025-03-11 13:25:02',
                'updated_at' => '2025-03-11 13:25:02'
            ],
            [
                'id' => 50,
                'category_id' => 25,
                'language_code' => 'en',
                'name' => 'Other',
                'url' => '#',
                'created_at' => '2025-03-11 13:25:02',
                'updated_at' => '2025-03-11 13:25:02'
            ],
            [
                'id' => 51,
                'category_id' => 26,
                'language_code' => 'th',
                'name' => 'ติดต่อ',
                'url' => '/contents/contact',
                'created_at' => '2025-03-11 13:26:05',
                'updated_at' => '2025-03-11 13:26:05'
            ],
            [
                'id' => 52,
                'category_id' => 26,
                'language_code' => 'en',
                'name' => 'Contact',
                'url' => '/contents/contact',
                'created_at' => '2025-03-11 13:26:05',
                'updated_at' => '2025-03-11 13:26:05'
            ],
            [
                'id' => 53,
                'category_id' => 27,
                'language_code' => 'th',
                'name' => 'กิจกรรม2',
                'url' => '/contents/1745479077-gjxus',
                'created_at' => '2025-04-22 07:01:26',
                'updated_at' => '2025-04-24 07:18:17'
            ],
            [
                'id' => 54,
                'category_id' => 27,
                'language_code' => 'en',
                'name' => 'Activity2',
                'url' => '/contents/1745479077-gjxus',
                'created_at' => '2025-04-22 07:01:26',
                'updated_at' => '2025-04-24 07:18:17'
            ],
        ];

        DB::table('menu_translations')->insert($menuTranslations);
    }
}
