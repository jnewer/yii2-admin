<?php

namespace backend\modules\logReader;

use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\web\Application;
use yii\web\GroupUrlRule;

/**
 * LogReader module definition class
 *
 * @property Log[] $logs
 * @property integer $totalCount
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    public $name = '日志管理';

    /**
     * @var array
     */
    public $aliases = [];
    /**
     * @var array
     */
    public $levelClasses = [
        'trace' => 'label-default',
        'info' => 'label-info',
        'warning' => 'label-warning',
        'error' => 'label-danger',
    ];
    /**
     * @var string
     */
    public $defaultLevelClass = 'label-default';
    /**
     * @var int
     */
    public $defaultTailLine = 100;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (!($app instanceof Application)) {
            throw new InvalidConfigException('Can use for web application only.');
        }

        $app->getUrlManager()->addRules([[
            'class' => GroupUrlRule::class,
            'prefix' => $this->id,
            'rules' => [
                '' => 'default/index',
                '<action:\w+>/<slug:[\w-]+>' => 'default/<action>',
                '<action:\w+>' => 'default/<action>',
            ],
        ]], false);
    }

    /**
     * @return Log[]
     */
    public function getLogs()
    {
        $logs = [];
        foreach ($this->aliases as $name => $alias) {
            $logs[] = new Log($name, $alias);
        }

        return $logs;
    }

    /**
     * @param string $slug
     * @param null|string $stamp
     * @return null|Log
     */
    public function findLog($slug, $stamp)
    {
        foreach ($this->aliases as $name => $alias) {
            if ($slug === Log::extractSlug($name)) {
                return new Log($name, $alias, $stamp);
            }
        }

        return null;
    }

    /**
     * @return Log[]
     */
    public function getHistory(Log $log)
    {
        $logs = [];
        foreach (glob(Log::extractFileName($log->alias, '*')) as $fileName) {
            $logs[] = new Log($log->name, $log->alias, Log::extractFileStamp($log->alias, $fileName));
        }

        return $logs;
    }

    /**
     * @return integer
     */
    public function getTotalCount()
    {
        $total = 0;
        foreach ($this->getLogs() as $log) {
            foreach ($log->getCounts() as $count) {
                $total += $count;
            }
        }

        return $total;
    }
}
