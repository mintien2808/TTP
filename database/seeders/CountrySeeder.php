<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class CountrySeeder extends Seeder
{
    public function run(){
        $states = [
            "SG" => ['Quận 1', 'Quận 3', 'Quận 5', 'Thủ Đức'],
            "HN" => ['Hoàn Kiếm', 'Đống Đa', 'Ba Đình', 'Cầu Giấy'],
            "HP" => ['Hồng Bàng', 'Lê Chân', 'Ngô Quyền'],
            "ĐN" => ['Hải Châu', 'Cẩm Lệ', 'Ngũ Hành Sơn', 'Thanh Khê'],
            "KT" => ['Đắk Hà', 'Kon Plông', 'Ngọc Hồi'],
            "BMT" => ['Ea Tam', 'Tân Lợi', 'Tân An'],
        ];
        $countries = [
            ['code' => 'SG', 'name' => 'Sài Gòn', 'states' => json_encode($states['SG'])],
            ['code' => 'HN', 'name' => 'Hà Nội', 'states' => json_encode($states['HN'])],
            ['code' => 'HP', 'name' => 'Hải Phòng', 'states' => json_encode($states['HP'])],
            ['code' => 'ĐN', 'name' => 'Đà Nẵng', 'states' => json_encode($states['ĐN'])],
            ['code' => 'KT', 'name' => 'Kontum', 'states' => json_encode($states['KT'])],
            ['code' => 'BMT', 'name' => 'Buôn Ma Thuột', 'states' => json_encode($states['BMT'])],
        ];
        Country::insert($countries);
    }
}
