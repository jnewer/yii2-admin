# Yii2 Admin Template

### 初始化

1. 克隆项目到本地

```
git clone https://github.com/jnewer/yii2-admin.git
```

2. 安装依赖

```
composer install
```

3. 初始化

```
php init
```

4. 配置数据库

```
common/config/main-local.php
```

5. 导入数据库

```
1.php yii migrate/up
```

```
2.php yii migrate/up --migrationPath=@yii/rbac/migrations
```

```
3.php yii migrate/up --migrationPath=@yii/log/migrations
```

6. 启动服务

```
php yii serve
```
