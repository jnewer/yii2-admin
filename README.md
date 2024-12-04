# Yii2 Skeleton

### 快速开始

#### 克隆项目到本地

```shell
git clone https://github.com/jnewer/yii2-skeleton.git
```

#### 安装依赖

```shell
composer install
```

#### 修改数据库配置

```
common/config/main-local.php
```

#### 执行数据库迁移

- 所有表

```shell
php yii migrate/up
```

- 权限相关

```shell
php yii migrate/up --migrationPath=@yii/rbac/migrations
```

- 日志相关

```shell
php yii migrate/up --migrationPath=@yii/log/migrations
```

- 配置相关

```shell
php yii migrate/up --migrationPath=@vendor/abhi1693/yii2-config/migrations
```

#### 创建管理员账号

```
php yii seed/create-admin
```

#### 配置开发工具

```php
// common/config/main-local.php
if (YII_ENV === 'dev') {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'queue' => \yii\queue\debug\Panel::class,
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['generators'] = [
        'bsgii-crud' => ['class' => backend\modules\bsgii\crud\Generator::class],
        'bsgii-model' => ['class' => backend\modules\bsgii\model\Generator::class],
        'job' => ['class' => \yii\queue\gii\Generator::class],
    ];
}
```

#### 启动服务

##### 启动后台服务

```
php yii serve --port=8080
```

##### 启动API服务

```
php yii serve --port=8081 --docroot=api/web
```

#### 关于权限生成

- 权限描述通过控制器或方法中的注释标签 `@desc` 进行正则匹配。例如，如果控制器类注释中包含 `@desc 用户管理`，则权限描述为`用户管理`；如果方法注释中包含 `@desc 查看`，则权限描述为`查看`。
<br>
- 在获取可添加的权限时，如果当前类继承了父类，默认会获取父类所有 `action` 的权限。可以通过指定变量 `parentActions` 的值来控制，例如 `public static $parentActions = ['index', 'view'];`，这样只会获取父类中指定的这些方法的权限。

#### 街道数据

- 需要将database/street.sql导入到数据库中。
