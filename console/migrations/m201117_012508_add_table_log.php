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
            `user_id` int(11) NOT NULL,
            `username` varchar(64) NOT NULL,
            `login_ip` varchar(128) NOT NULL,
            `updated_at` datetime NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            KEY `username` (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';");
        // 操作日志
        $this->execute("CREATE TABLE `operation_log` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
            `time` int(11) NOT NULL COMMENT '时间戳',
            `ip` char(15) NOT NULL COMMENT '操作员ip',
            `operator_id` int(11) DEFAULT NULL COMMENT '操作员id',
            `operator_name` varchar(50) NOT NULL COMMENT '操作员名',
            `type` varchar(50) NOT NULL COMMENT '操作行为的大类',
            `category` varchar(40) DEFAULT NULL COMMENT '该操作属于何种性质的操作(常规维护 或者其它 )',
            `description` varchar(255) DEFAULT NULL COMMENT '操作员输入的操作描述',
            `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已标记为删除. 0否, 1是.',
            `model` varchar(50) DEFAULT NULL COMMENT '操作的model',
            `model_pk` varchar(100) NOT NULL COMMENT '操作的model的主键',
            `model_attributes_old` text NOT NULL COMMENT '旧数据',
            `model_attributes_new` text NOT NULL COMMENT '新数据',
            PRIMARY KEY (`id`),
            KEY `date` (`date`),
            KEY `operator_id` (`operator_id`),
            KEY `operator_name` (`operator_name`),
            KEY `type` (`type`),
            KEY `category` (`category`)
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
