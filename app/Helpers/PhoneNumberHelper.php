<?php

namespace App\Helpers;

class PhoneNumberHelper
{
    public static function format($phone): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        if (str_starts_with($phone, '+62')) return $phone;
        if (str_starts_with($phone, '62')) return '+'.$phone;
        if (str_starts_with($phone, '0')) return '+62'.substr($phone, 1);

        return '+62'.$phone;
    }
}
