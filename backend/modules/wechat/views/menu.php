<?php

return  [
    'label' => '微信管理', 'icon' => 'fa fa-weixin', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
        ['label' => '配置管理', 'icon' => 'fa fa-cog', 'url' => ['/wechat/wechat-config/index']],
        ['label' => '粉丝管理', 'icon' => 'fa fa-users', 'url' => ['/wechat/wechat-user/index']],
    ]
];
