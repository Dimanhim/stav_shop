<?php

namespace backend\components;

class Helpers
{
    /**
     * @param $phone
     * @param bool $plus
     * @return mixed|string
     */
    public static function phoneFormat($phone, $plus = false)
    {
        if($phone) {
            $str = str_replace('-', '', $phone);
            $str = str_replace('(', '', $str);
            $str = str_replace(')', '', $str);
            $str = str_replace('_', '', $str);
            $str = str_replace(' ', '', $str);
            return $plus ? "+".$str : $str;
        }
        return '';
    }

    public static function setPhoneFormat($phone)
    {
        $phone = self::phoneFormat($phone);
        $phoneBody = substr($phone, -10);
        return '+7'.$phoneBody;
    }

    public static function getSecondsInTime($time)
    {
        $seconds = 0;
        $arr = explode(':', $time);
        $seconds += $arr[0] * 60 * 60;
        $seconds += $arr[1] * 60;
        return $seconds;
    }
    public static function getTimeAsString($time)
    {
        if($time) {
            $hours = floor($time / 60 / 60);
            $diff = $time - $hours * 60 * 60;
            $minutes = floor($diff / 60);
            return str_pad($hours, 2, 0, STR_PAD_LEFT).':'.str_pad($minutes, 2, 0, STR_PAD_LEFT);
        }
        return 0;
    }
}
