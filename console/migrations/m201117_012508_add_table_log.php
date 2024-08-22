<?php

use yii\db\Migration;

/**
 * Class m201117_012508_add_table_log
 */
class m201117_012508_add_table_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 登陆日志
        $this->execute("CREATE TABLE `login_log` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
            `username` varchar(64) NOT NULL DEFAULT '' COMMENT '用户名',
            `login_ip` varchar(45) NOT NULL COMMENT '登录IP',
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
            PRIMARY KEY (`id`),
            KEY `idx_user_id` (`user_id`),
            KEY `idx_username` (`username`),
            KEY `idx_created_at` (`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';");
        // 操作日志
        $this->execute("CREATE TABLE `operation_log` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
            `operator_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人名',
            `type` varchar(50) NOT NULL DEFAULT '' COMMENT '操作行为的大类',
            `category` varchar(40) DEFAULT '' COMMENT '该操作属于何种性质的操作(常规维护 或者其它 )',
            `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作员ip',
            `description` varchar(255) DEFAULT '' COMMENT '操作员输入的操作描述',
            `model` varchar(50) DEFAULT '' COMMENT '操作的model',
            `model_pk` varchar(100) NOT NULL DEFAULT '' COMMENT '操作的model的主键',
            `model_attributes_old` text NOT NULL COMMENT '旧数据',
            `model_attributes_new` text NOT NULL COMMENT '新数据',
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
            PRIMARY KEY (`id`),
            KEY `idx_operator_id` (`operator_id`),
            KEY `idx_operator_name` (`operator_name`),
            KEY `idx_type` (`type`),
            KEY `idx_category` (`category`),
            KEY `idx_created_at` (`created_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志表';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201117_012508_add_table_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201117_012508_add_table_log cannot be reverted.\n";

        return false;
    }
    */
}
