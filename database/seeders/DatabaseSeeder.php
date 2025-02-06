<?php

namespace Database\Seeders;

use App\Models\DisplayType;
use App\Models\NewType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::create([
        //     'f_name' => 'Test',
        //     'l_name' => 'User',
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('admin'),
        //     'tel' => '1234567890',
        // ]);

        // $newtype = new NewType();
        // $newtype->new_type_name = 'ข่าวประชาสัมพันธ์';
        // $newtype->status = 0;
        // $newtype->save();

        // $newtype = new NewType();
        // $newtype->new_type_name = 'ข่าวทุนวิจัย/อบรม';
        // $newtype->status = 0;
        // $newtype->save();

        // $newtype = new NewType();
        // $newtype->new_type_name = 'ข่าวจัดซื้อจัดจ้าง';
        // $newtype->status = 0;
        // $newtype->save();

        // $newtype = new NewType();
        // $newtype->new_type_name = 'ข่าววิชาการ';
        // $newtype->status = 0;
        // $newtype->save();

        $displaytype = new DisplayType();
        $displaytype->display_type_name = 'card';
        $displaytype->status = 0;
        $displaytype->save();

        $displaytype = new DisplayType();
        $displaytype->display_type_name = 'slide';
        $displaytype->status = 0;
        $displaytype->save();
    }
}
