<?php

use Illuminate\Database\Seeder;
use App\Repositories\Districts\District;
use App\Repositories\Provinces\Province;
use App\Repositories\DistrictPopulations\DistrictPopulation;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $provinces = [
            'Hà Nội(TP)'      => [
                'QUẬN HOÀN KIẾM',
                'QUẬN BA ĐÌNH',
                'QUẬN Tây Hồ',
                'QUẬN CẦU GIẤY',
                'QUẬN THANH XUÂN',
                'QUẬN ĐỐNG ĐA',
                'QUẬN HAI BÀ TRƯNG',
                'QUẬN HOÀNG MAI',
                'QUẬN LONG BIÊN',
                'QUẬN BẮC TỪ LIÊM',
                'QUẬN NAM TỪ LIÊM',
                'QUẬN HÀ ĐÔNG',
                'Huyện Sóc Sơn',
                'Huyện Đông Anh',
                'Huyện Gia Lâm',
                'Huyện Thanh Trì',
                'Huyện Ba Vì',
                'Huyện Phúc Thọ',
                'Huyện Mê Linh',
                'Huyện Đan Phượng',
                'Huyện Thạch Thất',
                'Huyện Hoài Đức',
                'Huyện Quốc Oai',
                'Huyện Chương Mỹ',
                'Huyện Thanh Oai',
                'Huyện Thường Tín',
                'Huyện Mỹ Đức',
                'Huyện ứng Hòa',
                'Huyện Phú Xuyên',
            ],
            'Hồ Chí Minh(TP)' => [
                'QUẬN 1',
                'QUẬN 2',
                'QUẬN 9',
                'QUẬN THỦ ĐỨC',
                'QUẬN GÒ VẤP',
                'QUẬN 12',
                'Huyện Củ Chi',
                'Huyện Hóc Môn',
                'Huyện Bình Chánh',
                'QUẬN BÌNH TÂN',
                'QUẬN TÂN PHÚ',
                'QUẬN TÂN BÌNH',
                'QUẬN PHÚ NHUẬN',
                'QUẬN BÌNH THẠNH',
                'QUẬN 3',
                'QUẬN 10',
                'QUẬN 11',
                'QUẬN 5',
                'QUẬN 4',
                'QUẬN 7',
                'QUẬN 8',
                'QUẬN 6',
                'Huyện Nhà Bè',
                'Huyện Cần Giờ',
            ],
        ];

        foreach ($provinces as $province => $districts) {
            $province = Province::create([
                'name' => $province
            ]);
            foreach ($districts as $district) {
                $district = District::create([
                    'name'        => $district,
                    'province_id' => $province->id
                ]);
                DistrictPopulation::create([
                    'district_id' => $district->id,
                    'population'  => random_int(1000, 1000000)
                ]);
                DistrictPopulation::create([
                    'district_id' => $district->id,
                    'population'  => random_int(1000, 1000000)
                ]);
            }

        }
    }
}
