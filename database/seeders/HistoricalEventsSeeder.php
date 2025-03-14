<?php

// database/seeders/HistoricalEventsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoricalEventsSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'year' => 2537,
                'title' => 'โครงการคณะอุตสาหกรรมศาสตร์ได้รับการบรรจุไว้ในแผนพัฒนาการศึกษาระดับอุดมศึกษา',
                'description' => 'โครงการคณะอุตสาหกรรมศาสตร์ได้รับการบรรจุไว้ในแผนพัฒนาการศึกษาระดับอุดมศึกษา พ.ศ. 2535 - 2539 ตามนโยบายการขยายโอกาสการศึกษาสู่ส่วนภูมิภาคของสถาบัน',
                'image_path' => 'history/kmitnb.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2538,
                'title' => 'จัดตั้งสาขาวิชาเทคโนโลยีสารสนเทศเพื่ออุตสาหกรรม',
                'description' => 'จัดตั้งสาขาวิชาเทคโนโลยีสารสนเทศเพื่ออุตสาหกรรม จัดการเรียนการสอนที่อาคารอเนกประสงค์ สถาบันเทคโนโลยีพระจอมเกล้าพระนครเหนือ กรุงเทพมหานคร และจัดตั้ง สถาบันเทคโนโลยีพระจอมเกล้าพระนครเหนือ ปราจีนบุรี โดยมีคณะเทคโนโลยีและการจัดการอุตสาหกรรมเป็นคณะแรกที่ สจพ.ปราจีนบุรี',
                'image_path' => 'history/kmutnb_1.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2539,
                'title' => 'คณะเทคโนโลยีและการจัดการอุตสาหกรรม ได้รับการจัดตั้งอย่างเป็นทางการ',
                'description' => 'คณะเทคโนโลยีและการจัดการอุตสาหกรรม ได้รับการจัดตั้งอย่างเป็นทางการโดยประกาศในราชกิจจานุเบกษา เมื่อวันที่ 6 สิงหาคม 2539 และ ผศ.วรวิทย์ จตุรพาณิชย์ ดำรงตำแหน่งคณบดีคณะเทคโนโลยีและการจัดการอุตสาหกรรม ตั้งแต่ พ.ศ.2539 - พ.ศ.2547',
                'image_path' => 'history/worawit.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2540,
                'title' => 'จัดการศึกษาครั้งแรกที่จังหวัดปราจีนบุรี',
                'description' => 'จัดการศึกษาครั้งแรกที่จังหวัดปราจีนบุรี ที่วิทยาลัยสารพัดช่างปราจีนบุรี โดยสาขาวิชาเทคโนโลยีสารสนเทศเพื่ออุตสาหกรรม',
                'image_path' => 'history/kmutnbold.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2541,
                'title' => 'อาคารหลังแรกของ สจพ.ปราจีนบุรี แล้วเสร็จ',
                'description' => 'อาคารหลังแรกของ สจพ.ปราจีนบุรี แล้วเสร็จ คือ อาคารอเนกประสงค์ และใช้เป็นสถานที่จัดการเรียนการสอน และจัดตั้งสาขาวิชาการจัดการอุตสาหกรรม และ สาขาวิชาการบริหารงานก่อสร้าง',
                'image_path' => 'history/AN1.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2542,
                'title' => 'อาคารคณะเทคโนโลยีและการจัดการอุตสาหกรรม แล้วเสร็จ',
                'description' => 'อาคารคณะเทคโนโลยีและการจัดการอุตสาหกรรม แล้วเสร็จ และคณะได้ย้ายที่ทำการและจัดการเรียนการสอนที่ สจพ.ปราจีนบุรี อย่างเต็มรูปแบบ และจัดตั้งสาขาวิชาเทคโนโลยีเครื่องจักรกลเกษตร',
                'image_path' => 'history/fitm42.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2546,
                'title' => 'จัดตั้งสาขาวิชาการจัดการอุตสาหกรรมการท่องเที่ยว และการโรงแรม',
                'description' => 'จัดตั้งสาขาวิชาการจัดการอุตสาหกรรมการท่องเที่ยว และการโรงแรม (ปัจจุบันสังกัดคณะบริหารธุรกิจ และอุตสาหกรรมบริการ)',
                'image_path' => 'history/villa.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2547,
                'title' => 'ผศ.พีระศักดิ์ เสรีกุล ดำรงตำแหน่งคณบดี',
                'description' => 'ผศ.พีระศักดิ์ เสรีกุล ดำรงตำแหน่งคณบดีคณะเทคโนโลยีและการจัดการอุตสาหกรรม ตั้งแต่ปี พ.ศ. 2547-2555 และปรับรูปแบบโครงสร้างองค์กรจากสาขาวิชาเป็นภาควิชา',
                'image_path' => 'history/Peerasak.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2550,
                'title' => 'เปลี่ยนสถานภาพเป็นมหาวิทยาลัย',
                'description' => 'สถาบันเทคโนโลยีพระจอมเกล้าพระนครเหนือ เปลี่ยนสถานภาพเป็น "มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ"',
                'image_path' => 'history/kmitnb-kmutnb.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2553,
                'title' => 'โรงแรมวิลล่าวิชชาลัย เปิดใช้งาน',
                'description' => 'โรงแรมวิลล่าวิชชาลัย ใช้เป็นอาคารฝึกปฏิบัติงานของนักศึกษาและให้บริการ เป็นที่พักรับรองสำหรับบุคคลทั่วไป (ปัจจุบันอยู่ภายใต้การบริหารงานของ คณะบริหารธุรกิจและอุตสาหกรรมบริการ)',
                'image_path' => 'history/villa_STD.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2555,
                'title' => 'รศ.ดร.อนิราช มิ่งขวัญ ดำรงตำแหน่งคณบดี',
                'description' => 'รศ.ดร.อนิราช มิ่งขวัญ ดำรงตำแหน่งคณบดีคณะเทคโนโลยีและการจัดการอุตสาหกรรม ตั้งแต่ปี พ.ศ.2555-2563',
                'image_path' => 'history/Anirach.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2556,
                'title' => 'มีตราสัญลักษณ์ (logo) อย่างเป็นทางการ',
                'description' => 'มีตราสัญลักษณ์ (logo) ของคณะเทคโนโลยีและการจัดการอุตสาหกรรมอย่างเป็นทางการและใช้มาจนปัจจุบัน',
                'image_path' => 'history/FITM-LOGO-MODIFILED.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2559,
                'title' => 'ปรับโครงสร้างองค์กร',
                'description' => 'คณะเทคโนโลยีและการจัดการอุตสาหกรรม ประกอบด้วย 5 ส่วนงาน คือ ภาควิชาเทคโนโลยีสารสนเทศ, ภาควิชาการจัดการอุตสาหกรรม, ภาควิชาการออกแบบและบริหารงานก่อสร้าง, ภาควิชาวิศวกรรมเกษตรเพื่ออุตสาหกรรม และสำนักงานคณบดี',
                'image_path' => 'history/wisdom.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => 2563,
                'title' => 'ผศ.ดร.กฤษฎากร บุดดาจันทร์ ดำรงตำแหน่งคณบดี',
                'description' => 'ผศ.ดร.กฤษฎากร บุดดาจันทร์ ดำรงตำแหน่งคณบดี คณะเทคโนโลยีและการจัดการอุตสาหกรรม ตั้งแต่ปี พ.ศ.2563 จนถึงปัจจุบัน',
                'image_path' => 'history/Khridsadakhon.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('historical_events')->insert($events);
    }
}
