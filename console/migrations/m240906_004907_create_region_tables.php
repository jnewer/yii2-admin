<?php

use yii\db\Migration;

/**
 * Class m240906_004907_create_region_tables
 */
class m240906_004907_create_region_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS province (
      id mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
      name varchar(30) NOT NULL DEFAULT '' COMMENT '省份名称',
      PRIMARY KEY (id)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='省份表';");

        $this->execute("CREATE TABLE IF NOT EXISTS city (
      id mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
      name varchar(60) NOT NULL DEFAULT '' COMMENT '城市名称',
      pid mediumint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '省份id',
      PRIMARY KEY (id),
      KEY idx_pid (pid)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='城市表';");

        $this->execute("CREATE TABLE IF NOT EXISTS area (
      id mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
      name varchar(60) NOT NULL DEFAULT '' COMMENT '区域名称',
      pid mediumint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '城市id',
      PRIMARY KEY (id),
      KEY idx_pid (pid)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='区域表';");

        $this->execute("CREATE TABLE IF NOT EXISTS street (
      id mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
      name varchar(60) NOT NULL DEFAULT '' COMMENT '街道名称',
      pid mediumint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '区域id',
      PRIMARY KEY (id),
      KEY idx_pid (pid)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='街道表';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240906_004907_create_region_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240906_004907_create_region_tables cannot be reverted.\n";

        return false;
    }
    */
}
