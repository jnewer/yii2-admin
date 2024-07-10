<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->unique()->defaultValue('')->comment('用户名'),
            'nickname' => $this->string(32)->notNull()->defaultValue('')->comment('昵称'),
            'auth_key' => $this->string(32)->notNull()->defaultValue('')->comment('授权KEY'),
            'password_hash' => $this->string(64)->notNull()->defaultValue('')->comment('密码哈希值'),
            'password_reset_token' => $this->string(64)->unique()->comment('密码重置TOKEN'),
            'access_token' => $this->string(64)->unique()->comment('ACCESS TOKEN'),
            'email' => $this->string(32)->notNull()->unique()->comment('邮箱'),
            'status' => $this->tinyInteger(1)->notNull()->unsigned()->defaultValue(10)->comment('状态'),
            'created_at' => $this->dateTime()->notNull()->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
