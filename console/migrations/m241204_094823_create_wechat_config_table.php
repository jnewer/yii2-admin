<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wechat_config}}`.
 */
class m241204_094823_create_wechat_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wechat_config}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(50)->comment('名称'),
            'app_id' => $this->string(50)->notNull()->defaultValue('')->comment('AppID'),
            'app_secret' => $this->string(50)->notNull()->defaultValue('')->comment('AppSecret'),
            'server_url' => $this->string(100)->comment('服务器地址'),
            'token' => $this->string(50)->notNull()->defaultValue('')->comment('Token'),
            'encoding_aes_key' => $this->string(50)->notNull()->defaultValue('')->comment('EncodingAESKey'),
            'kind' => $this->tinyInteger()->unsigned()->defaultValue(0)->comment('账号分类'),
            'login_email' => $this->string(50)->notNull()->defaultValue('')->comment('登录邮箱'),
            'login_password' => $this->string(50)->notNull()->defaultValue('')->comment('登录密码'),
            'original_id' => $this->string(30)->null()->comment('原始ID'),
            'qrcode_url' => $this->string(200)->notNull()->defaultValue('')->comment('二维码URL'),
            'auth_type' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('授权类型'),
            'status' => $this->integer()->unsigned()->notNull()->defaultValue(1)->comment('状态'),
            'welcome_msg' => $this->string(200)->notNull()->defaultValue('')->comment('欢迎语'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
        ]);

        $this->createIndex('idx_name', '{{%wechat_config}}', 'name');
        $this->createIndex('idx_app_id', '{{%wechat_config}}', 'app_id');
        $this->createIndex('uk_original_id', '{{%wechat_config}}', 'original_id', true);

        $this->addCommentOnTable('{{%wechat_config}}', '微信公众账号配置');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wechat_config}}');
    }
}
