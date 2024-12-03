<?php

namespace backend\modules\rbac\models;

use yii\data\ArrayDataProvider;
use dektrium\rbac\models\Role as BaseRole;

class Role extends BaseRole
{
    public function getUnassignedItemsDataProvider()
    {
        $items = [];
        foreach ($this->getUnassignedItems() as $name => $value) {
            $items[] = ['name' => $name, 'description' => $value];
        }

        return new ArrayDataProvider([
            'allModels' => $items,
            'sort' => [
                'attributes' => ['name'],
                'defaultOrder' => ['name' => SORT_ASC],
            ],
            'pagination' => false,
        ]);
    }
}
