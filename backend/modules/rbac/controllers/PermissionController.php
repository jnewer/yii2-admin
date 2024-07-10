<?php

namespace backend\modules\rbac\controllers;

use Yii;
use backend\modules\rbac\models\GenerateForm;
use backend\modules\rbac\components\Generator;
use dektrium\rbac\controllers\PermissionController as BaseController;

/**
 * Default controller for the `rbac` module
 */
class PermissionController extends BaseController
{
    public function actionGenerate()
    {
        // Get the generator and authorizer
        $generator = Yii::createObject([
            'class'   => Generator::class,
        ]);

        // Createh the form model
        $model = new GenerateForm();

        // Form has been submitted
        if (isset($_POST['GenerateForm']) === true) {
            // Form is valid
            $model->attributes = $_POST['GenerateForm'];
            if ($model->validate() === true) {
                $items = array(
                    'tasks' => array(),
                    'operations' => array(),
                );

                // Get the chosen items
                foreach ($model->items as $itemname => $value) {
                    if ((bool)$value === true) {
                        $items['operations'][] = $itemname;
                    }
                }

                // Add the items to the generator as tasks and operations and run the generator.
                /** @var Generator $generator */
                $generator->addItems($items['operations']);
                if (($generatedItems = $generator->run()) !== false && $generatedItems !== array()) {
                    Yii::$app->getSession()->setFlash(
                        'success',
                        '权限项已生成'
                    );
                    return $this->redirect(array('permission/generate'));
                }
            }
        }

        // Get all items that are available to be generated
        $items = $generator->getControllerActions();

        // We need the existing operations for comparason
        $authItems = Yii::$app->authManager->getPermissions();
        $existingItems = array();
        foreach ($authItems as $itemName => $item) {
            $existingItems[$itemName] = $itemName;
        }

        // Render the view
        return $this->render('generate', array(
            'model' => $model,
            'items' => $items,
            'existingItems' => $existingItems,
        ));
    }
}
