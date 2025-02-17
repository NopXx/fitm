<?php

namespace Database\Seeders;

use App\Models\DisplayType;
use App\Models\NewType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
        ]);
        // User::factory(10)->create();

        // User::create([
        //     'f_name' => 'Test',
        //     'l_name' => 'User',
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('admin'),
        //     'tel' => '1234567890',
        // ]);

        $newtype = new NewType();
        $newtype->new_type_name = 'ข่าวประชาสัมพันธ์';
        $newtype->status = 0;
        $newtype->save();

        $newtype = new NewType();
        $newtype->new_type_name = 'ข่าวทุนวิจัย/อบรม';
        $newtype->status = 0;
        $newtype->save();

        $newtype = new NewType();
        $newtype->new_type_name = 'ข่าวจัดซื้อจัดจ้าง';
        $newtype->status = 0;
        $newtype->save();

        $newtype = new NewType();
        $newtype->new_type_name = 'ข่าววิชาการ';
        $newtype->status = 0;
        $newtype->save();

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
class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'department_name_th' => 'ภาควิชาเทคโนโลยีสารสนเทศ',
                'department_code' => 'IT',
            ],
            [
                'department_name_th' => 'ภาควิชาการจัดการอุตสาหกรรม',
                'department_code' => 'IM',
            ],
            [
                'department_name_th' => 'ภาควิชาการออกแบบและบริการงานก่อสร้าง',
                'department_code' => 'CDM',
            ],
            [
                'department_name_th' => 'ภาควิชาวิศวกรรมเทเบอร์เพื่ออุตสาหกรรม',
                'department_code' => 'AEI',
            ],
            [
                'department_name_th' => 'สำนักงานคณบดี',
                'department_code' => 'Office',
            ],
        ];

        DB::table('departments')->insert($departments);
    }
}
