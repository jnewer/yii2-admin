<?php

namespace backend\modules\logReader\controllers;

use backend\modules\logReader\Log;
use backend\modules\logReader\Module;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    /**
     * @var Module
     */
    public $module;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->rememberUrl();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->module->getLogs(),
            'sort' => [
                'attributes' => [
                    'name',
                    'size' => ['default' => SORT_DESC],
                    'updatedAt' => ['default' => SORT_DESC],
                ],
            ],
            'pagination' => ['pageSize' => 0],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'defaultTailLine' => $this->module->defaultTailLine,
        ]);
    }

    /**
     * @param string $slug
     * @param string $stamp
     * @return $this
     */
    public function actionView($slug, $stamp = null)
    {
        $log = $this->find($slug, $stamp);
        if ($log->isExist) {
            return Yii::$app->response->sendFile($log->fileName, basename($log->fileName), [
                'mimeType' => 'text/plain',
                'inline' => true
            ]);
        }

        throw new NotFoundHttpException('日志不存在.');
    }

    // /**
    //  * @param string $slug
    //  * @return Response
    //  */
    // public function actionArchive($slug)
    // {
    //     if (!$this->find($slug, null)->archive(date('YmdHis'))) {
    //         throw new NotFoundHttpException('日志不存在.');
    //     }

    //     Yii::$app->session->setFlash('success', '归档成功');

    //     return $this->redirect(['history', 'slug' => $slug]);
    // }

    /**
     * @param string $slug
     * @return string
     */
    public function actionHistory($slug)
    {
        $this->rememberUrl();

        $log = $this->find($slug, null);
        $allLogs = $this->module->getHistory($log);

        $fullSize = array_sum(ArrayHelper::getColumn($allLogs, 'size'));

        $dataProvider = new ArrayDataProvider([
            'allModels' => $allLogs,
            'sort' => [
                'attributes' => [
                    'fileName',
                    'size' => ['default' => SORT_DESC],
                    'updatedAt' => ['default' => SORT_DESC],
                ],
                'defaultOrder' => ['updatedAt' => SORT_DESC],
            ],
        ]);

        return $this->render('history', [
            'name' => $log->name,
            'dataProvider' => $dataProvider,
            'fullSize' => $fullSize,
            'defaultTailLine' => $this->module->defaultTailLine,
        ]);
    }

    /**
     * @param string $slug
     * @param null|string $stamp
     * @param null|string $since
     * @return Response
     */
    public function actionDelete($slug, $stamp = null, $since = null)
    {
        $log = $this->find($slug, $stamp);
        if ($since && $log->updatedAt != $since) {
            Yii::$app->session->setFlash('error', '删除失败: 文件已更新');
            return $this->redirectPrevious();
        }

        if (unlink($log->fileName)) {
            Yii::$app->session->setFlash('success', '删除成功');
        } else {
            Yii::$app->session->setFlash('error', '删除失败');
        }

        return $this->redirectPrevious();
    }

    /**
     * @param string $slug
     * @param null|string $stamp
     * @return void
     */
    public function actionDownload($slug, $stamp = null)
    {
        $log = $this->find($slug, $stamp);
        if ($log->isExist) {
            Yii::$app->response->sendFile($log->fileName)->send();
        } else {
            throw new NotFoundHttpException('日志不存在.');
        }
    }

    /**
     * @param string  $slug
     * @param integer $line
     * @param null|string  $stamp
     * @return string|false|null
     */
    public function actionTail($slug, $line = 100, $stamp = null)
    {
        $alias = $this->module->aliases;
        if (!isset($alias[$slug])) {
            throw new NotFoundHttpException('日志不存在.');
        }
        // 去掉slug中传入路径的非法字符
        $slug = preg_replace('/[\/\\\]/', '', $slug);
        $line = intval($line);
        if ($line > 100) {
            $line = 100;
        }
        $log = $this->find($slug, $stamp);
        if ($log->isExist) {
            $result = shell_exec("tail -n {$line} {$log->fileName}");

            Yii::$app->response->format = Response::FORMAT_RAW;
            // Yii::$app->response->headers->set('Content-Type', 'text/event-stream');
            return $result;
        }

        throw new NotFoundHttpException('日志不存在.');
    }

    /**
     * @param string $slug
     * @param null|string $stamp
     * @return Log
     * @throws NotFoundHttpException
     */
    protected function find($slug, $stamp)
    {
        if ($log = $this->module->findLog($slug, $stamp)) {
            return $log;
        }

        throw new NotFoundHttpException('日志不存在.');
    }

    protected function rememberUrl($url = '')
    {
        Url::remember($url, '__logReaderReturnUrl');
    }

    protected function redirectPrevious()
    {
        return $this->redirect(Url::previous('__logReaderReturnUrl'));
    }
}
