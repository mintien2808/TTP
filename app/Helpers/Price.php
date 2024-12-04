<?php

namespace App\Helpers;

class PriceHelper
{
    public static function format_price_vnd($price)
    {
        return number_format($price, 0, ',', '.') . ' VNĐ';
    }
}