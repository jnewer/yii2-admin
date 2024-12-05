<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wechat_user}}`.
 */
class m241204_093705_create_wechat_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wechat_user}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'wechat_config_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('公众号配置ID'),
            'openid' => $this->string(32)->comment('openid'),
            'nickname' => $this->string(32)->comment('昵称'),
            'sex' => $this->tinyInteger(1)->unsigned()->defaultValue(0)->comment('性别'),
            'province' => $this->string(20)->notNull()->defaultValue('')->comment('省份'),
            'city' => $this->string(20)->notNull()->defaultValue('')->comment('城市'),
            'country' => $this->string(20)->notNull()->defaultValue('')->comment('国家'),
            'headimgurl' => $this->string(255)->notNull()->defaultValue('')->comment('头像'),
            'privilege' => $this->string(512)->comment('用户特权信息'),
            'unionid' => $this->string(32)->comment('unionid'),
            'access_token' => $this->string(64)->notNull()->defaultValue('')->comment('access_token'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
            'subscribed_at' => $this->dateTime()->null()->comment('关注时间'),
        ]);

        $this->createIndex('idx_wechat_config_id', '{{%wechat_user}}', 'wechat_config_id');
        $this->createIndex('idx_openid', '{{%wechat_user}}', 'openid');
        $this->createIndex('idx_nickname', '{{%wechat_user}}', 'nickname');

        $this->addCommentOnTable('{{%wechat_user}}', '微信用户表');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wechat_user}}');
    }
}
