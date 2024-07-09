<?php

if (!function_exists('app')) {
    /**
     * @inheritdoc
     */
    function app()
    {
        return Yii::$app;
    }
}


if (!function_exists('param')) {
    function param($name, $default = null)
    {
        return app()->params[$name] ?? $default;
    }
}


if (!function_exists('db')) {
    /**
     * Returns the database connection component.
     * @return \yii\db\Connection
     */
    function db($db = 'db')
    {
        return app()->get($db);
    }
}

if (!function_exists('slaveDb')) {
    /**
     * Returns the database connection component.
     * @return \yii\db\Connection
     */
    function slaveDb()
    {
        return app()->get('slaveDb');
    }
}

if (!function_exists('request')) {
    /**
     * @inheritdoc
     */
    function request()
    {
        return app()->getRequest();
    }
}

if (!function_exists('response')) {
    /**
     * @inheritdoc
     */
    function response()
    {
        return app()->getResponse();
    }
}

if (!function_exists('isPost')) {
    /**
     * @inheritdoc
     */
    function isPost()
    {
        return request()->getIsPost();
    }
}

if (!function_exists('post')) {
    /**
     * @inheritdoc
     */
    function post($name = null, $defaultValue = null)
    {
        return request()->post($name, $defaultValue);
    }
}

if (!function_exists('isGet')) {
    /**
     * @inheritdoc
     */
    function isGet()
    {
        return request()->getIsGet();
    }
}

if (!function_exists('get')) {
    /**
     * @inheritdoc
     */
    function get($name = null, $defaultValue = null)
    {
        return request()->get($name, $defaultValue);
    }
}

if (!function_exists('isOptions')) {
    /**
     * @inheritdoc
     */
    function isOptions()
    {
        return request()->getIsOptions();
    }
}

if (!function_exists('config')) {

    /**
     * @inheritdoc
     */
    function config()
    {
        return app()->config;
    }
}

if (!function_exists('getConfig')) {

    /**
     * @inheritdoc
     */
    function getConfig($name, $default = null)
    {
        return Yii::$app->config->get($name, $default);
    }
}

if (!function_exists('setConfig')) {

    /**
     * @inheritdoc
     */
    function setConfig($name, $value = null)
    {
        return Yii::$app->config->set($name, $value);
    }
}

if (!function_exists('getMyId')) {
    /**
     * @return int|string
     */
    function getMyId()
    {
        return Yii::$app->user->getId();
    }
}

if (!function_exists('render')) {
    /**
     * @inheritdoc
     */
    function render($view, $params = [])
    {
        return Yii::$app->controller->render($view, $params);
    }
}

if (!function_exists('redirect')) {
    /**
     * @inheritdoc
     */
    function redirect($url, $statusCode = 302)
    {
        return Yii::$app->controller->redirect($url, $statusCode);
    }
}

if (!function_exists('transaction')) {
    /**
     * @inheritdoc
     */
    function transaction()
    {
        return db()->beginTransaction();
    }
}

if (!function_exists('session')) {
    /**
     * @inheritdoc
     */
    function session()
    {
        return app()->session;
    }
}


if (!function_exists('setFlash')) {
    /**
     * @inheritdoc
     */
    function setFlash($key, $value = true, $removeAfterAccess = true)
    {
        session()->setFlash($key, $value, $removeAfterAccess);
    }
}

if (!function_exists('cache')) {
    /**
     * @inheritdoc
     */
    function cache()
    {
        return app()->cache;
    }
}

if (!function_exists('getCache')) {
    /**
     * @inheritdoc
     */
    function getCache($key)
    {
        cache()->get($key);
    }
}

if (!function_exists('setCache')) {
    /**
     * @inheritdoc
     */
    function setCache($key, $value, $duration = null, $dependency = null)
    {
        cache()->set($key, $value, $duration, $dependency);
    }
}

if (!function_exists('deleteCache')) {
    /**
     * @inheritdoc
     */
    function deleteCache($key)
    {
        cache()->delete($key);
    }
}


if (!function_exists('mutex')) {
    /**
     * @inheritdoc
     */
    function mutex()
    {
        return app()->mutex;
    }
}

if (!function_exists('redis')) {
    /**
     * @inheritdoc
     */
    function redis()
    {
        return app()->redis;
    }
}

if (!function_exists('queue')) {
    /**
     * @inheritdoc
     */
    function queue()
    {
        return app()->queue;
    }
}

if (!function_exists('formatter')) {
    /**
     * @inheritdoc
     */
    function formatter()
    {
        return app()->formatter;
    }
}

if (!function_exists('basePath')) {
    /**
     * @inheritdoc
     */
    function basePath()
    {
        return app()->basePath;
    }
}

if (!function_exists('runtimePath')) {
    /**
     * @inheritdoc
     */
    function runtimePath()
    {
        return app()->runtimePath;
    }
}

if (!function_exists('user')) {

    /**
     * @inheritdoc
     */
    function user()
    {
        return app()->user;
    }
}

if (!function_exists('isAdmin')) {
    /**
     * @inheritdoc
     */
    function isAdmin()
    {
        return user()->getIsAdmin();
    }
}

if (!function_exists('hasRole')) {
    /**
     * @inheritdoc
     */
    function isRole($roleName)
    {
        return user()->isRole($roleName);
    }
}


if (!function_exists('dbCmd')) {

    /**
     * @inheritdoc
     */
    function dbCmd($sql = null, $params = [])
    {
        return db()->createCommand($sql, $params);
    }
}
