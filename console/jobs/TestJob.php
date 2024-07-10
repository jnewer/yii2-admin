<?php

namespace console\jobs;

/**
 * Class TestJob.
 */
class TestJob extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $id;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
