<?php

namespace backend\modules\rbac\components;

use Yii;

/**
 * Rights generator component class file.
 */
class Generator extends \yii\base\Component
{
    private $_authManager;
    private $_items;

    /**
     * @property CDbConnection
     */
    public $db;

    /**
     * Initializes the generator.
     */
    public function init()
    {
        parent::init();

        $this->_authManager = Yii::$app->getAuthManager();
        $this->db = $this->_authManager->db;
    }

    /**
     * Runs the generator.
     * @return the items generated or false if failed.
     */
    public function run()
    {
        $authManager = $this->_authManager;
        $itemTable = $authManager->itemTable;

        // Start transaction
        $txn = $this->db->beginTransaction();

        try {
            $generatedItems = array();

            // Loop through each type of items
            foreach ($this->_items as $type => $items) {
                // Loop through items
                foreach ($items as $name) {
                    // Make sure the item does not already exist
                    if ($authManager->getPermission($name) === null) {
                        // Insert item
                        $sql = "INSERT INTO {$itemTable} (name, type, description, created_at, updated_at)
							VALUES (:name, :type,:description, :created_at, :updated_at)";
                        $command = $this->db->createCommand($sql);
                        $command->bindValue(':name', $name);
                        $command->bindValue(':type', $type);
                        $command->bindValue(':description', $this->parseDescByAuthItem($name));
                        $command->bindValue(':created_at', time());
                        $command->bindValue(':updated_at', time());
                        $command->execute();

                        $generatedItems[] = $name;
                    }
                }
            }

            // All commands executed successfully, commit
            $txn->commit();
            return $generatedItems;
        } catch (\Exception $e) {
            // Something went wrong, rollback
            $txn->rollback();
            return false;
        }
    }

    /**
     * Appends items to be generated of a specific type.
     * @param array $items the items to be generated.
     * @param integer $type the item type.
     */
    public function addItems($items, $type = 2)
    {
        if (isset($this->_items[$type]) === false) {
            $this->_items[$type] = array();
        }

        foreach ($items as $itemname) {
            $this->_items[$type][] = $itemname;
        }
    }

    /**
     * Returns all the controllers and their actions.
     * @param array $items the controllers and actions.
     */
    public function getControllerActions($items = null)
    {
        if ($items === null) {
            $items = $this->getAllControllers();
        }

        foreach ($items['controllers'] as $controllerName => $controller) {
            $actions = array();
            $file = fopen($controller['path'], 'r');
            $lineNumber = 0;
            while (feof($file) === false) {
                ++$lineNumber;
                $line = fgets($file);
                preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $matches);
                if ($matches !== array()) {
                    $name = $matches[1];
                    $actions[strtolower($name)] = array(
                        'name' => $name,
                        'desc' => $this->getMethodDesc($controller['class'], 'action' . $name),
                        'line' => $lineNumber
                    );
                }
            }

            $actions = $this->appendParentsActions($controller['class'], $actions);
            $items['controllers'][$controllerName]['actions'] = $actions;
        }

        foreach ($items['modules'] as $moduleName => $module) {
            $items['modules'][$moduleName] = $this->getControllerActions($module);
        }

        return $items;
    }

    /**
     * Returns a list of all application controllers.
     * @return array the controllers.
     */
    protected function getAllControllers()
    {
        $basePath = Yii::$app->basePath;
        $items['controllers'] = $this->getControllersInPath($basePath . DIRECTORY_SEPARATOR . 'controllers');
        $items['modules'] = $this->getControllersInModules($basePath);
        return $items;
    }

    /**
     * Returns all controllers under the specified path.
     * @param string $path the path.
     * @return array the controllers.
     */
    protected function getControllersInPath($path)
    {
        $controllers = array();

        if (file_exists($path) === true) {
            $controllerDirectory = scandir($path);
            foreach ($controllerDirectory as $entry) {
                if ($entry[0]!=='.') {
                    $entryPath = $path . DIRECTORY_SEPARATOR . $entry;
                    if (strpos(strtolower($entry), 'controller') !== false) {
                        $name = substr($entry, 0, -14);
                        $class = $this->parseControllerClass($entryPath);
                        $controllers[strtolower($name)] = array(
                            'name' => $name,
                            'file' => $entry,
                            'path' => $entryPath,
                            'class' => $class,
                            'desc' => $this->getClassDesc($class)
                        );
                    }

                    if (is_dir($entryPath) === true) {
                        foreach ($this->getControllersInPath($entryPath) as $controllerName => $controller) {
                            $controllers[$controllerName] = $controller;
                        }
                    }
                }
            }
        }

        return $controllers;
    }

    /**
     * Returns all the controllers under the specified path.
     * @param string $path the path.
     * @return array the controllers.
     */
    protected function getControllersInModules($path)
    {
        $items = array();

        $modulePath = $path . DIRECTORY_SEPARATOR . 'modules';
        if (file_exists($modulePath) === true) {
            $moduleDirectory = scandir($modulePath);
            foreach ($moduleDirectory as $entry) {
                if (substr($entry, 0, 1) !== '.' && $entry !== 'rbac') {
                    $subModulePath = $modulePath . DIRECTORY_SEPARATOR . $entry;
                    if (file_exists($subModulePath) === true) {
                        $items[$entry]['controllers'] = $this->getControllersInPath($subModulePath . DIRECTORY_SEPARATOR . 'controllers');
                        $items[$entry]['modules'] = $this->getControllersInModules($subModulePath);
                    }
                }
            }
        }

        return $items;
    }

    public function parseControllerClass($classFile)
    {
        $fileParts = explode('backend', $classFile);
        $filename = explode('.', $fileParts[1])[0];

        return str_replace(DIRECTORY_SEPARATOR, '\\', 'backend' . $filename);
    }

    public function appendParentsActions($controllerClass, $controllerActions)
    {
        if (!property_exists($controllerClass, 'parentActions')) {
            return $controllerActions;
        }

        $parentActions = $controllerClass::$parentActions;
        $controllerActionNames = array_column($controllerActions, 'name');
        if (empty($parentActions)) {
            return $controllerActions;
        }

        foreach ($parentActions as $parentAction) {
            if (in_array($parentAction, $controllerActionNames)) {
                continue;
            }

            $controllerActions[strtolower($parentAction)] = array(
                'name' => $parentAction,
                'desc' => $this->getMethodDesc($controllerClass, 'action' . $parentAction),
                'line' => '继承父类'
            );
        }

        return $controllerActions;
    }

    public function getDescComment($docComment)
    {
        if (preg_match('/@desc\s+(.*)\n/', $docComment, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * 获取方法注释中的 @desc 标签的值
     *
     * @param string $className 类名
     * @param string $methodName 方法名
     * @return string @desc 标签的值，如果没有找到则返回 ''
     */
    public function getMethodDesc($className, $methodName)
    {
        try {
            // 创建类的反射对象
            $reflectionClass = new \ReflectionClass($className);

            // 获取方法的反射对象
            $reflectionMethod = $reflectionClass->getMethod($methodName);

            // 获取方法的注释
            $docComment = $reflectionMethod->getDocComment();

            // 使用正则表达式匹配 @desc 标签的值
            return $this->getDescComment($docComment);
        } catch (\ReflectionException $e) {
            return '';
        }
    }

    /**
     * 获取类注释中的 @desc 标签的值
     *
     * @param string $className 类名
     * @return string @desc 标签的值，如果没有找到则返回 ''
     */
    public function getClassDesc($className)
    {
        try {
            // 创建类的反射对象
            $reflectionClass = new \ReflectionClass($className);

            // 获取类的注释
            $docComment = $reflectionClass->getDocComment();

            // 使用正则表达式匹配 @desc 标签的值
            return $this->getDescComment($docComment);
        } catch (\ReflectionException $e) {
            return '';
        }
    }

    public function parseDescByAuthItem($authItem)
    {
        $authItem = explode('.', $authItem);

        if (count($authItem) == 2) {
            $controller = 'backend\\controllers\\'.$authItem[0].'Controller';
            $action = 'action' . $authItem[1];
        } else {
            $controller = 'backend\\modules\\'.$authItem[0].'\\controllers\\'.$authItem[1].'Controller';
            $action = 'action' . $authItem[2];
        }

        if ($action === '*') {
            return $this->getClassDesc($controller);
        }

        return $this->getMethodDesc($controller, $action);
    }
}
