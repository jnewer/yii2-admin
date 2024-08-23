<?php

namespace backend\widgets;

use Yii;
use yii\grid\ActionColumn as BaseActionColumn;

class ActionColumn extends BaseActionColumn
{
    /**
     * @inheritDoc
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', ['class' => 'btn btn-default btn-sm']);
        $this->initDefaultButton('update', 'pencil', ['class' => 'btn btn-primary btn-sm']);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn btn-danger btn-sm'
        ]);
    }
}
