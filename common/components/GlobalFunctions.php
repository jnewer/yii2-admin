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

if (!function_exists('slave_db')) {
    /**
     * Returns the database connection component.
     * @return \yii\db\Connection
     */
    function slave_db()
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

if (!function_exists('is_get')) {
    /**
     * @inheritdoc
     */
    function is_get()
    {
        return request()->getis_get();
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

if (!function_exists('is_options')) {
    /**
     * @inheritdoc
     */
    function is_options()
    {
        return request()->getis_options();
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

if (!function_exists('get_config')) {

    /**
     * @inheritdoc
     */
    function get_config($name, $default = null)
    {
        return Yii::$app->config->get($name, $default);
    }
}

if (!function_exists('set_config')) {

    /**
     * @inheritdoc
     */
    function set_config($name, $value = null)
    {
        return Yii::$app->config->set($name, $value);
    }
}

if (!function_exists('admin_id')) {
    /**
     * @return int|string
     */
    function admin_id()
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


if (!function_exists('set_flash')) {
    /**
     * @inheritdoc
     */
    function set_flash($key, $value = true, $removeAfterAccess = true)
    {
        session()->set_flash($key, $value, $removeAfterAccess);
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

if (!function_exists('get_cache')) {
    /**
     * @inheritdoc
     */
    function get_cache($key)
    {
        cache()->get($key);
    }
}

if (!function_exists('set_cache')) {
    /**
     * @inheritdoc
     */
    function set_cache($key, $value, $duration = null, $dependency = null)
    {
        cache()->set($key, $value, $duration, $dependency);
    }
}

if (!function_exists('delete_cache')) {
    /**
     * @inheritdoc
     */
    function delete_cache($key)
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

if (!function_exists('bash_path')) {
    /**
     * @inheritdoc
     */
    function bash_path()
    {
        return app()->bash_path;
    }
}

if (!function_exists('runtime_path')) {
    /**
     * @inheritdoc
     */
    function runtime_path()
    {
        return app()->runtime_path;
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

if (!function_exists('is_admin')) {
    /**
     * @inheritdoc
     */
    function is_admin()
    {
        return user()->getis_admin();
    }
}

if (!function_exists('is_role')) {
    /**
     * @inheritdoc
     */
    function isRole($roleName)
    {
        return user()->isRole($roleName);
    }
}


if (!function_exists('db_cmd')) {

    /**
     * @inheritdoc
     */
    function db_cmd($sql = null, $params = [])
    {
        return db()->createCommand($sql, $params);
    }
}

