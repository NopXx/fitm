<?php

namespace Database\Seeders;

use App\Models\OnlineService;
use Illuminate\Database\Seeder;

class OnlineServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title_th' => 'วิสัยทัศน์/ยุทธศาสตร์ KM',
                'title_en' => 'Vision/Strategy KM',
                'image' => 'services/web_KM.png',
                'link' => 'https://sites.google.com/fitm.kmutnb.ac.th/km-fitm',
                'active' => true,
                'order' => 1,
            ],
            [
                'title_th' => 'บริการออนไลน์ FITM',
                'title_en' => 'FITM Online Services',
                'image' => 'services/online_fitm.png',
                'link' => '/contents/it-service',
                'active' => true,
                'order' => 2,
            ],
            [
                'title_th' => 'IT SUPPORT',
                'title_en' => 'IT SUPPORT',
                'image' => 'services/itsupport.png',
                'link' => 'https://sites.google.com/itm.kmutnb.ac.th/itsupport/home',
                'active' => true,
                'order' => 3,
            ],
            [
                'title_th' => 'OPEN HOUSE',
                'title_en' => 'OPEN HOUSE',
                'image' => 'services/openhouse.png',
                'link' => 'https://sites.google.com/fitm.kmutnb.ac.th/fitmopenhouse',
                'active' => true,
                'order' => 4,
            ],
            [
                'title_th' => 'QA',
                'title_en' => 'QA',
                'image' => 'services/FITM_QA.png',
                'link' => 'https://sites.google.com/fitm.kmutnb.ac.th/aunqa4',
                'active' => true,
                'order' => 5,
            ],
            [
                'title_th' => 'เอกสารดาวน์โหลด',
                'title_en' => 'Download Documents',
                'image' => 'services/download.png',
                'link' => '/contents/dowload',
                'active' => true,
                'order' => 6,
            ],
            [
                'title_th' => 'ประเมินคุณธรรมและความโปร่งใส',
                'title_en' => 'Ethics and Transparency Assessment',
                'image' => 'services/FITM_ITA.png',
                'link' => '/contents/ITA',
                'active' => true,
                'order' => 7,
            ],
            [
                'title_th' => 'จรรยาบรรณ/ธรรมาภิบาล',
                'title_en' => 'Ethics/Good Governance',
                'image' => 'services/kmutnbjan.png',
                'link' => 'https://hrd.kmutnb.ac.th/%e0%b8%88%e0%b8%a3%e0%b8%a3%e0%b8%a2%e0%b8%b2%e0%b8%9a%e0%b8%a3%e0%b8%a3%e0%b8%93-%e0%b8%98%e0%b8%a3%e0%b8%a3%e0%b8%a1%e0%b8%b2%e0%b8%a0%e0%b8%b4%e0%b8%9a%e0%b8%b2%e0%b8%a5/',
                'active' => true,
                'order' => 8,
            ],
        ];

        foreach ($services as $service) {
            OnlineService::create($service);
        }

        // Optional: Create additional random services
        // OnlineService::factory(5)->create();
    }
}
