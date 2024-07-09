<?php


namespace common\helpers;

class DatetimeHelper
{
    /**
     * @return int
     */
    public static function getMicRoTime()
    {
        return (int)sprintf('%.0f', microtime(true) * 1000);
    }
}
