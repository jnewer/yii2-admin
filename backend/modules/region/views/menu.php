<?php

return  [
    'label' => '地区管理', 'icon' => 'fa fa-book', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
        ['label' => '省份管理', 'icon' => 'fa fa-flag', 'url' => ['/region/province/index']],
        ['label' => '城市管理', 'icon' => 'fa fa-map-marker', 'url' => ['/region/city/index']],
        ['label' => '区域管理', 'icon' => 'fa fa-map', 'url' => ['/region/area/index']],
        ['label' => '街道管理', 'icon' => 'fa fa-road', 'url' => ['/region/street/index']]
    ]
];
