<?php

namespace console\controllers;

use backend\models\LoginLog;
use yii;
use yii\console\ExitCode;
use backend\models\OperationLog;
use common\models\Log;

/**
 * 数据库日志清理后台任务
 */
class LogController extends \yii\console\Controller
{
    /**
     * @return int
     */
    public function actionTruncate()
    {
        $count = Yii::$app->db->createCommand()->truncateTable(Log::tableName())->execute();

        echo "清理系统日志成功，共清理 $count 条数据。\n";

        return ExitCode::OK;
    }

    public function actionDropOperationLog()
    {
        $count = OperationLog::deleteAll(['<=', 'date', date('Y-m-d', strtotime('-1 year')) . ' 23:59:59']);

        echo "清理操作日志成功，共清理 $count 条数据。\n";

        return ExitCode::OK;
    }

    public function actionDropLoginLog()
    {
        $count = LoginLog::deleteAll(['<=', 'date', date('Y-m-d', strtotime('-1 year')) . ' 23:59:59']);

        echo "清理登录日志成功，共清理 $count 条数据。\n";

        return ExitCode::OK;
    }
}
