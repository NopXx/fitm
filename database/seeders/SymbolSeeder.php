<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Symbol;

class SymbolSeeder extends Seeder
{
    public function run()
    {
        $symbols = [
            [
                'type' => Symbol::TYPE_UNIVERSITY_EMBLEM,
                'name_th' => 'พระมหามงกุฏ',
                'name_en' => 'KMUTNB\'s Emblem',
                'description_th' => 'พระบาทสมเด็จพระเจ้าอยู่หัว รัชกาลที่ 9 ได้พระราชทานพระบรมราชานุญาตให้อัญเชิญ "พระมหามงกุฏ" ซึ่งเป็นพระบรมราชลัญจกร ประจำพระองค์พระบาทสมเด็จพระจอมเกล้าเจ้าอยู่หัว รัชกาลที่ 4 ให้เป็นตราประจำมหาวิทยาลัย',
                'description_en' => 'The Great Crown of Victory emblem granted by King Rama IX',
                'image_path' => 'symbols/logo_kmutnb.png',
                'download_link' => 'https://drive.google.com/drive/folders/0BzjXOQgDrQZARGREd1JFQ2FqcnM'
            ],
            [
                'type' => Symbol::TYPE_UNIVERSITY_COLOR,
                'name_th' => 'สีแดงหมากสุก',
                'name_en' => 'KMUTNB\'s Color',
                'description_th' => 'เป็นสีประจำในพระบาทสมเด็จพระจอมเกล้าเจ้าอยู่หัว รัชกาลที่ 4 ที่มหาวิทยาลัยอัญเชิญมาเป็นสีประจำมหาวิทยาลัย',
                'description_en' => 'Ripe Betel Nut Red Color',
                'image_path' => 'symbols/color_kmutnb.png',
                'rgb_code' => '#AC3520',
                'cmyk_code' => '5%, 85%, 85%, 30%'
            ],
            [
                'type' => Symbol::TYPE_UNIVERSITY_TREE,
                'name_th' => 'ต้นประดู่แดง',
                'name_en' => 'The Tree of KMUTNB',
                'description_th' => 'เป็นไม้เนื้อแข็งที่มีความแข็งแกร่งซึ่งแสดงถึงความแข็งแกร่งของมหาวิทยาลัย ดอกมีสีแดงเข้มเหมือนหมากสุกซึ่งตรงกับสีประจำมหาวิทยาลัยและจะออกดอกในช่วงเดือนกุมภาพันธ์ ซึ่งตรงกับวันสถาปนามหาวิทยาลัย คือ วันที่ 19 กุมภาพันธ์ ของทุกปี',
                'description_en' => 'Red Pterocarpus Tree',
                'image_path' => 'symbols/pradudang.png'
            ],
            [
                'type' => Symbol::TYPE_FACULTY_LOGO,
                'name_th' => 'ตราสัญลักษณ์คณะเทคโนโลยีและการจัดการอุตสาหกรรม',
                'name_en' => 'Faculty of Industrial Technology and Management Logo',
                'description_th' => 'รูปเหลี่ยมอิสระสีฟ้าที่มีมุมเอียงชี้ขึ้นด้านบนแสดงถึงที่ตั้งซึ่งอยู่ด้านเขตเงาฝนของเทือกเขาดงพญาเย็น-เขาใหญ่ และมีความหมายในเชิงสัญลักษณ์หมายถึงความมั่นคงของคณะนับจนถึงปัจจุบัน ส่วนสีฟ้าเป็นสีประจำคณะ รูปเหลี่ยม 4 รูปด้านซ้ายของตราสัญลักษณ์ หมายถึง ภาควิชาทั้งสี่ของคณะ ที่มีการดำเนินการสอดรับผสมผสานอย่างกลมกลืน',
                'description_en' => 'FITM Logo',
                'image_path' => 'symbols/FITM-LOGO-MODIFILED.png',
                'download_link' => 'https://drive.google.com/file/d/0B5yNM-Tx05IjcjRIMWpkdXBZQm8/view'
            ],
            [
                'type' => 'university_logo',
                'name_th' => 'โลโก้ มจพ.',
                'name_en' => 'KMUTNB Logo',
                'description_th' => 'โลโก้มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ',
                'description_en' => 'King Mongkut\'s University of Technology North Bangkok Logo',
                'image_path' => 'symbols/logokmutnbfinal.png',
                'download_link' => 'https://drive.google.com/drive/folders/1Ze-s_s3pymy0sZ5DhFnYcp1zxC0SzvjA'
            ]
        ];

        foreach ($symbols as $symbol) {
            Symbol::create($symbol);
        }
    }
}
