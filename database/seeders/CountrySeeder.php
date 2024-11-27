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
        $usaStates = [
            "SG" => 'Sài Gòn',
            "HN" => 'Hà Nội',
            "HP" => 'Hải Phòng',
            "ĐN" => 'Đà Nẵng',
            "KT" => 'Kontum',
            'BMT' => 'Buôn Ma Thuột',
        ];
        $countries = [
            ['code' => 'geo', 'name' => 'Georgia', 'states' => null],
            ['code' => 'ind', 'name' => 'India', 'states' => null],
            ['code' => 'vn', 'name' => 'Việt Nam', 'states' => json_encode($usaStates)],
            ['code' => 'ger', 'name' => 'Germany', 'states' => null],
        ];
        Country::insert($countries);
    }
}
