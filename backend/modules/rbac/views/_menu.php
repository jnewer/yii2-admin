<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this yii\web\View
 */

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs'
    ],
    'activateParents' =>true,
    'items' => [
        [
            'label'   => '用户',
            'url'     => ['/user/admin/index'],
            'visible' => isset(Yii::$app->extensions['dektrium/yii2-user']),
        ],
        [
            'label' => '角色',
            'url'   => ['/rbac/role/index'],
            'active'=> $this->context->id == 'role',
        ],
        [
            'label' => '权限',
            'url'   => ['/rbac/permission/index'],
            'active'=> $this->context->id == 'permission',
        ],
        [
            'label' => '创建',
            'options' => [
                'class' => 'pull-right'
            ],
            'active'=> false,
            'items' => [
                [
                    'label'   => '新用户',
                    'url'     => ['/user/admin/create'],
                    'visible' => isset(Yii::$app->extensions['dektrium/yii2-user']),
                ],
                [
                    'label' => '创建新角色',
                    'url'   => ['/rbac/role/create']
                ],
                [
                    'label' => '创建新权限',
                    'url'   => ['/rbac/permission/create']
                ],
                [
                    'label' => '批量生成',
                    'url'   => ['/rbac/permission/generate']
                ]
            ]
        ]
    ]
]) ?>
