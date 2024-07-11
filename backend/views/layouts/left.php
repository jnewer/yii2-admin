<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!-- <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> -->

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..." />
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= backend\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu', 'data-widget' => "tree"],
                'items' => [
                    ['label' => '系统首页', 'icon' => 'fa fa-dashboard', 'url' => ['/']],
                    ['label' => '服务环境', 'icon' => 'fa fa-file-code-o', 'url' => ['/site/server-env']],
                    ['label' => '权限管理', 'icon' => 'fa fa-lock', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
                        ['label' => '用户管理', 'icon' => 'fa fa-users', 'url' => ['/user']],
                        ['label' => '权限管理', 'icon' => 'fa fa-lock', 'url' => ['/rbac'], 'visible' => Yii::$app->user->isAdmin],
                    ]],
                    ['label' => '系统设置', 'icon' => 'fa fa-cog', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
                        ['label' => '配置管理', 'icon' => 'fa fa-cogs', 'url' => ['/config']],
                    ]],
                    ['label' => '日志管理', 'icon' => 'fa fa-book', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
                        ['label' => '系统日志', 'icon' => 'fa fa-bug', 'url' => ['/log'], 'visible' => Yii::$app->user->isAdmin],
                        ['label' => '登录日志', 'icon' => 'fa fa-user', 'url' => ['/login-log'], 'visible' => Yii::$app->user->isAdmin],
                        ['label' => '操作日志', 'icon' => 'fa fa-history', 'url' => ['/operation-log'], 'visible' => Yii::$app->user->isAdmin],
                        ['label' => '文件日志', 'icon' => 'fa fa-file-text-o', 'url' => ['/log-reader'], 'visible' => Yii::$app->user->isAdmin]
                    ]],
                    [
                        'label' => '开发工具',
                        'icon' => 'fa fa-code',
                        'url' => '#',
                        'visible' => (YII_ENV == 'dev'),
                        'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'], 'linkOptions' => ['target' => '_blank']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
