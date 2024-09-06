<?php

use yii\db\Migration;

/**
 * Class m240906_005249_create_province_data
 */
class m240906_005249_create_province_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `province` (`id`, `name`) VALUES 
(1,'北京'),
(2,'上海'),
(3,'天津'),
(4,'重庆'),
(5,'河北'),
(6,'山西'),
(7,'河南'),
(8,'辽宁'),
(9,'吉林'),
(10,'黑龙江'),
(11,'内蒙古'),
(12,'江苏'),
(13,'山东'),
(14,'安徽'),
(15,'浙江'),
(16,'福建'),
(17,'湖北'),
(18,'湖南'),
(19,'广东'),
(20,'广西'),
(21,'江西'),
(22,'四川'),
(23,'海南'),
(24,'贵州'),
(25,'云南'),
(26,'西藏'),
(27,'陕西'),
(28,'甘肃'),
(29,'青海'),
(30,'宁夏'),
(31,'新疆'),
(52993,'港澳'),
(32,'台湾');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240906_005249_create_province_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240906_005249_create_province_data cannot be reverted.\n";

        return false;
    }
    */
}
