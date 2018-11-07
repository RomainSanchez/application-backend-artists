<?php

namespace App\Utils;

class TimeConverter
{
    public static function timeToSeconds(string $time): float
    {
        $length = explode(":", $time);

        return ($length[0] * 60) + $length[1];
    }

    public static function secondstoMinutes(float $seconds): string
    {
        return gmdate("i:s", $seconds) . "mn";
    }
}