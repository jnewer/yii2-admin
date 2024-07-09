<?php


namespace api\modules\v2\components\helper;


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