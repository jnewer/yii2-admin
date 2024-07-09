<?php


namespace api\modules\v2\components\helper;

class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * 将名称中的斜杠替换
     * @param string $fileName
     * @return string|string[]
     */
    public static function normalizeFileName($fileName = '')
    {
        return str_replace('\\', '＼', str_replace('/', '／', $fileName));
    }

    /**
     * 获取唯一请求ID
     * @return string
     */
    public static function createRequestId()
    {
        $redis = \Yii::$app->redis;
        $key = $redis->scard('request-id-list') >= 100 ? $redis->spop('request-id-list') : DatetimeHelper::getMicRoTime();
        $requestId = self::format(strtoupper(hash_hmac('md5', uniqid($key, true), 'request-id')));
        $redis->sadd('request-id-list', $requestId);
        return $requestId;
    }

    /**
     * @param $requestId
     * @param int[] $format
     * @return string
     */
    protected static function format($requestId, $format = [8, 4, 4, 4, 12])
    {
        $tmp = [];
        $offset = 0;
        if (!empty($format)) {
            foreach ($format as $item) {
                $tmp[] = substr($requestId, $offset, $item);
                $offset += $item;
            }
        }

        if ($offset < strlen($requestId)) {
            $tmp[] = substr($requestId, $offset);
        }
        return join('-', $tmp);
    }
}
