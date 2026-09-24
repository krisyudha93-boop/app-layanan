<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;

class DistrictVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [
                'code' => '35.05.01',
                'name' => 'Wonotirto',
                'villages' => [
                    ['code' => '35.05.01.2001', 'name' => 'Wonotirto'],
                    ['code' => '35.05.01.2002', 'name' => 'Kaligrenjeng'],
                    ['code' => '35.05.01.2003', 'name' => 'Gununggede'],
                    ['code' => '35.05.01.2004', 'name' => 'Tambakrejo'],
                    ['code' => '35.05.01.2005', 'name' => 'Pasiraman'],
                    ['code' => '35.05.01.2006', 'name' => 'Ngadipuro'],
                    ['code' => '35.05.01.2007', 'name' => 'Sumberboto'],
                    ['code' => '35.05.01.2008', 'name' => 'Ngeni'],
                ],
            ],
            [
                'code' => '35.05.02',
                'name' => 'Bakung',
                'villages' => [
                    ['code' => '35.05.02.2001', 'name' => 'Bakung'],
                    ['code' => '35.05.02.2002', 'name' => 'Plandirejo'],
                    ['code' => '35.05.02.2003', 'name' => 'Kedungbanteng'],
                    ['code' => '35.05.02.2004', 'name' => 'Tumpakkepuh'],
                    ['code' => '35.05.02.2005', 'name' => 'Sidomulyo'],
                    ['code' => '35.05.02.2006', 'name' => 'Pulerejo'],
                    ['code' => '35.05.02.2007', 'name' => 'Sumberdadi'],
                ],
            ],
            [
                'code' => '35.05.03',
                'name' => 'Panggungrejo',
                'villages' => [
                    ['code' => '35.05.03.2001', 'name' => 'Panggungrejo'],
                    ['code' => '35.05.03.2002', 'name' => 'Margomulyo'],
                    ['code' => '35.05.03.2003', 'name' => 'Serang'],
                    ['code' => '35.05.03.2004', 'name' => 'Kalitengah'],
                    ['code' => '35.05.03.2005', 'name' => 'Bumiayu'],
                    ['code' => '35.05.03.2006', 'name' => 'Sumberagung'],
                ],
            ],
            [
                'code' => '35.05.04',
                'name' => 'Wates',
                'villages' => [
                    ['code' => '35.05.04.2001', 'name' => 'Wates'],
                    ['code' => '35.05.04.2002', 'name' => 'Tugurejo'],
                    ['code' => '35.05.04.2003', 'name' => 'Mojorejo'],
                    ['code' => '35.05.04.2004', 'name' => 'Purworejo'],
                    ['code' => '35.05.04.2005', 'name' => 'Ringinrejo'],
                    ['code' => '35.05.04.2006', 'name' => 'Tulungrejo'],
                ],
            ],
            [
                'code' => '35.05.05',
                'name' => 'Binangun',
                'villages' => [
                    ['code' => '35.05.05.2001', 'name' => 'Binangun'],
                    ['code' => '35.05.05.2002', 'name' => 'Rejoso'],
                    ['code' => '35.05.05.2003', 'name' => 'Sambigede'],
                    ['code' => '35.05.05.2004', 'name' => 'Ngadri'],
                    ['code' => '35.05.05.2005', 'name' => 'Tawangrejo'],
                    ['code' => '35.05.05.2006', 'name' => 'Birowo'],
                    ['code' => '35.05.05.2007', 'name' => 'Kedungwungu'],
                ],
            ],
            [
                'code' => '35.05.06',
                'name' => 'Sutojayan',
                'villages' => [
                    ['code' => '35.05.06.1001', 'name' => 'Sutojayan'],
                    ['code' => '35.05.06.1002', 'name' => 'Kalipang'],
                    ['code' => '35.05.06.1003', 'name' => 'Kembangarum'],
                    ['code' => '35.05.06.1004', 'name' => 'Jegu'],
                    ['code' => '35.05.06.1005', 'name' => 'Sukorejo'],
                    ['code' => '35.05.06.1006', 'name' => 'Kedungbunder'],
                    ['code' => '35.05.06.1007', 'name' => 'Pandanarum'],
                    ['code' => '35.05.06.2008', 'name' => 'Bacem'],
                    ['code' => '35.05.06.2009', 'name' => 'Sumberrejo'],
                    ['code' => '35.05.06.2010', 'name' => 'Kaulon'],
                    ['code' => '35.05.06.2011', 'name' => 'Plandirejo'],
                ],
            ],
            [
                'code' => '35.05.07',
                'name' => 'Kademangan',
                'villages' => [
                    ['code' => '35.05.07.1001', 'name' => 'Kademangan'],
                    ['code' => '35.05.07.2002', 'name' => 'Plosorejo'],
                    ['code' => '35.05.07.2003', 'name' => 'Rejotangan'],
                    ['code' => '35.05.07.2004', 'name' => 'Sumberjo'],
                    ['code' => '35.05.07.2005', 'name' => 'Suruhwadang'],
                    ['code' => '35.05.07.2006', 'name' => 'Maron'],
                    ['code' => '35.05.07.2007', 'name' => 'Pakisaji'],
                    ['code' => '35.05.07.2008', 'name' => 'Darungan'],
                    ['code' => '35.05.07.2009', 'name' => 'Jimbe'],
                    ['code' => '35.05.07.2010', 'name' => 'Bendosari'],
                    ['code' => '35.05.07.2011', 'name' => 'Dawuhan'],
                ],
            ],
            [
                'code' => '35.05.08',
                'name' => 'Kanigoro',
                'villages' => [
                    ['code' => '35.05.08.1001', 'name' => 'Kanigoro'],
                    ['code' => '35.05.08.1002', 'name' => 'Satreyan'],
                    ['code' => '35.05.08.2003', 'name' => 'Sawentar'],
                    ['code' => '35.05.08.2004', 'name' => 'Gaprang'],
                    ['code' => '35.05.08.2005', 'name' => 'Kuningan'],
                    ['code' => '35.05.08.2006', 'name' => 'Tlogo'],
                    ['code' => '35.05.08.2007', 'name' => 'Banggle'],
                    ['code' => '35.05.08.2008', 'name' => 'Papungan'],
                    ['code' => '35.05.08.2009', 'name' => 'Karangsono'],
                    ['code' => '35.05.08.2010', 'name' => 'Minggirsari'],
                    ['code' => '35.05.08.2011', 'name' => 'Gogodeso'],
                    ['code' => '35.05.08.2012', 'name' => 'Jatinom'],
                ],
            ],
            [
                'code' => '35.05.09',
                'name' => 'Talun',
                'villages' => [
                    ['code' => '35.05.09.1001', 'name' => 'Kamulan'],
                    ['code' => '35.05.09.1002', 'name' => 'Talun'],
                    ['code' => '35.05.09.2003', 'name' => 'Pasirharjo'],
                    ['code' => '35.05.09.2004', 'name' => 'Kendalrejo'],
                    ['code' => '35.05.09.2005', 'name' => 'Bendosewu'],
                    ['code' => '35.05.09.2006', 'name' => 'Jeblog'],
                    ['code' => '35.05.09.2007', 'name' => 'Tumpang'],
                    ['code' => '35.05.09.2008', 'name' => 'Duren'],
                ],
            ],
            [
                'code' => '35.05.10',
                'name' => 'Selopuro',
                'villages' => [
                    ['code' => '35.05.10.2001', 'name' => 'Selopuro'],
                    ['code' => '35.05.10.2002', 'name' => 'Jatitengah'],
                    ['code' => '35.05.10.2003', 'name' => 'Jambewangi'],
                    ['code' => '35.05.10.2004', 'name' => 'Popoh'],
                    ['code' => '35.05.10.2005', 'name' => 'Mandisan'],
                    ['code' => '35.05.10.2006', 'name' => 'Ploso'],
                ],
            ],
            [
                'code' => '35.05.11',
                'name' => 'Kesamben',
                'villages' => [
                    ['code' => '35.05.11.2001', 'name' => 'Kesamben'],
                    ['code' => '35.05.11.2002', 'name' => 'Siraman'],
                    ['code' => '35.05.11.2003', 'name' => 'Pagergunung'],
                    ['code' => '35.05.11.2004', 'name' => 'Tapakrejo'],
                    ['code' => '35.05.11.2005', 'name' => 'Sukoanyar'],
                    ['code' => '35.05.11.2006', 'name' => 'Pojok'],
                    ['code' => '35.05.11.2007', 'name' => 'Bumiayu'],
                ],
            ],
            [
                'code' => '35.05.12',
                'name' => 'Wlingi',
                'villages' => [
                    ['code' => '35.05.12.1001', 'name' => 'Wlingi'],
                    ['code' => '35.05.12.1002', 'name' => 'Beru'],
                    ['code' => '35.05.12.1003', 'name' => 'Babadan'],
                    ['code' => '35.05.12.1004', 'name' => 'Klemunan'],
                    ['code' => '35.05.12.1005', 'name' => 'Tangkil'],
                    ['code' => '35.05.12.2006', 'name' => 'Tembalang'],
                    ['code' => '35.05.12.2007', 'name' => 'Balerejo'],
                    ['code' => '35.05.12.2008', 'name' => 'Ngadirenggo'],
                    ['code' => '35.05.12.2009', 'name' => 'Tegalasri'],
                ],
            ],
            [
                'code' => '35.05.13',
                'name' => 'Doko',
                'villages' => [
                    ['code' => '35.05.13.2001', 'name' => 'Doko'],
                    ['code' => '35.05.13.2002', 'name' => 'Resapombo'],
                    ['code' => '35.05.13.2003', 'name' => 'Suryorejo'],
                    ['code' => '35.05.13.2004', 'name' => 'Genengan'],
                    ['code' => '35.05.13.2005', 'name' => 'Plumbangan'],
                    ['code' => '35.05.13.2006', 'name' => 'Sumberejo'],
                ],
            ],
            [
                'code' => '35.05.14',
                'name' => 'Gandusari',
                'villages' => [
                    ['code' => '35.05.14.2001', 'name' => 'Gandusari'],
                    ['code' => '35.05.14.2002', 'name' => 'Kotes'],
                    ['code' => '35.05.14.2003', 'name' => 'Ngaringan'],
                    ['code' => '35.05.14.2004', 'name' => 'Gondang'],
                    ['code' => '35.05.14.2005', 'name' => 'Gadungan'],
                    ['code' => '35.05.14.2006', 'name' => 'Sukosewu'],
                    ['code' => '35.05.14.2007', 'name' => 'Tambakan'],
                ],
            ],
            [
                'code' => '35.05.15',
                'name' => 'Garum',
                'villages' => [
                    ['code' => '35.05.15.1001', 'name' => 'Garum'],
                    ['code' => '35.05.15.1002', 'name' => 'Tawangsari'],
                    ['code' => '35.05.15.1003', 'name' => 'Bence'],
                    ['code' => '35.05.15.1004', 'name' => 'Sumberdiren'],
                    ['code' => '35.05.15.2005', 'name' => 'Pojok'],
                    ['code' => '35.05.15.2006', 'name' => 'Tingal'],
                    ['code' => '35.05.15.2007', 'name' => 'Slorok'],
                    ['code' => '35.05.15.2008', 'name' => 'Karangrejo'],
                    ['code' => '35.05.15.2009', 'name' => 'Sidodadi'],
                ],
            ],
            [
                'code' => '35.05.16',
                'name' => 'Nglegok',
                'villages' => [
                    ['code' => '35.05.16.1001', 'name' => 'Nglegok'],
                    ['code' => '35.05.16.2002', 'name' => 'Penataran'],
                    ['code' => '35.05.16.2003', 'name' => 'Ngoran'],
                    ['code' => '35.05.16.2004', 'name' => 'Modangan'],
                    ['code' => '35.05.16.2005', 'name' => 'Sumberasri'],
                    ['code' => '35.05.16.2006', 'name' => 'Kedawung'],
                    ['code' => '35.05.16.2007', 'name' => 'Bangsri'],
                    ['code' => '35.05.16.2008', 'name' => 'Dayu'],
                    ['code' => '35.05.16.2009', 'name' => 'Jiwut'],
                    ['code' => '35.05.16.2010', 'name' => 'Krenceng'],
                ],
            ],
            [
                'code' => '35.05.17',
                'name' => 'Sanankulon',
                'villages' => [
                    ['code' => '35.05.17.2001', 'name' => 'Sanankulon'],
                    ['code' => '35.05.17.2002', 'name' => 'Bendowulung'],
                    ['code' => '35.05.17.2003', 'name' => 'Kalipucung'],
                    ['code' => '35.05.17.2004', 'name' => 'Purworejo'],
                    ['code' => '35.05.17.2005', 'name' => 'Plosoarang'],
                    ['code' => '35.05.17.2006', 'name' => 'Sumber'],
                    ['code' => '35.05.17.2007', 'name' => 'Sumberjo'],
                    ['code' => '35.05.17.2008', 'name' => 'Tuliskriyo'],
                    ['code' => '35.05.17.2009', 'name' => 'Gledug'],
                ],
            ],
            [
                'code' => '35.05.18',
                'name' => 'Ponggok',
                'villages' => [
                    ['code' => '35.05.18.2001', 'name' => 'Ponggok'],
                    ['code' => '35.05.18.2002', 'name' => 'Bacem'],
                    ['code' => '35.05.18.2003', 'name' => 'Bendo'],
                    ['code' => '35.05.18.2004', 'name' => 'Candirejo'],
                    ['code' => '35.05.18.2005', 'name' => 'Dadaplangu'],
                    ['code' => '35.05.18.2006', 'name' => 'Gembongan'],
                    ['code' => '35.05.18.2007', 'name' => 'Jatilengger'],
                    ['code' => '35.05.18.2008', 'name' => 'Karanganyar'],
                    ['code' => '35.05.18.2009', 'name' => 'Kebonduren'],
                    ['code' => '35.05.18.2010', 'name' => 'Maliran'],
                    ['code' => '35.05.18.2011', 'name' => 'Pojok'],
                    ['code' => '35.05.18.2012', 'name' => 'Ringinanyar'],
                    ['code' => '35.05.18.2013', 'name' => 'Sidorejo'],
                ],
            ],
            [
                'code' => '35.05.19',
                'name' => 'Srengat',
                'villages' => [
                    ['code' => '35.05.19.1001', 'name' => 'Srengat'],
                    ['code' => '35.05.19.1002', 'name' => 'Kauman'],
                    ['code' => '35.05.19.1003', 'name' => 'Dandong'],
                    ['code' => '35.05.19.1004', 'name' => 'Togogan'],
                    ['code' => '35.05.19.2005', 'name' => 'Selokajang'],
                    ['code' => '35.05.19.2006', 'name' => 'Karanggayam'],
                    ['code' => '35.05.19.2007', 'name' => 'Dermojayan'],
                    ['code' => '35.05.19.2008', 'name' => 'Kandangan'],
                    ['code' => '35.05.19.2009', 'name' => 'Purwokerto'],
                    ['code' => '35.05.19.2010', 'name' => 'Maron'],
                    ['code' => '35.05.19.2011', 'name' => 'Wonorejo'],
                ],
            ],
            [
                'code' => '35.05.20',
                'name' => 'Wonodadi',
                'villages' => [
                    ['code' => '35.05.20.2001', 'name' => 'Wonodadi'],
                    ['code' => '35.05.20.2002', 'name' => 'Pikatan'],
                    ['code' => '35.05.20.2003', 'name' => 'Gandekan'],
                    ['code' => '35.05.20.2004', 'name' => 'Kolomayan'],
                    ['code' => '35.05.20.2005', 'name' => 'Tawangrejo'],
                    ['code' => '35.05.20.2006', 'name' => 'Kebonagung'],
                ],
            ],
            [
                'code' => '35.05.21',
                'name' => 'Udanawu',
                'villages' => [
                    ['code' => '35.05.21.2001', 'name' => 'Bakung'],
                    ['code' => '35.05.21.2002', 'name' => 'Besuki'],
                    ['code' => '35.05.21.2003', 'name' => 'Bendorejo'],
                    ['code' => '35.05.21.2004', 'name' => 'Karanggondang'],
                    ['code' => '35.05.21.2005', 'name' => 'Ringinanom'],
                    ['code' => '35.05.21.2006', 'name' => 'Sukun'],
                    ['code' => '35.05.21.2007', 'name' => 'Tunjung'],
                ],
            ],
            [
                'code' => '35.05.22',
                'name' => 'Selorejo',
                'villages' => [
                    ['code' => '35.05.22.2001', 'name' => 'Selorejo'],
                    ['code' => '35.05.22.2002', 'name' => 'Banjarsari'],
                    ['code' => '35.05.22.2003', 'name' => 'Ngrendeng'],
                    ['code' => '35.05.22.2004', 'name' => 'Pohgajih'],
                    ['code' => '35.05.22.2005', 'name' => 'Sidomulyo'],
                    ['code' => '35.05.22.2006', 'name' => 'Ampelgading'],
                ],
            ],
        ];

        foreach ($districts as $d) {
            $district = District::updateOrCreate(
                ['code' => $d['code']],
                ['name' => $d['name']]
            );

            foreach ($d['villages'] as $v) {
                Village::updateOrCreate(
                    ['code' => $v['code']],
                    [
                        'district_id' => $district->id,
                        'name' => $v['name'],
                    ]
                );
            }
        }
    }
}
