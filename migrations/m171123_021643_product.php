<?php

use yii\db\Migration;

/**
 * Class m171123_021643_product
 */
class m171123_021643_product extends Migration
{
    /**
     * @inheritdoc
     */
    // public function up()
    // {

    // }

    /**
     * @inheritdoc
     */
    // public function down()
    // {
    //     echo "m171123_021643_product cannot be reverted.\n";

    //     return false;
    // }

    
    // Use up()/down() to run migration code without a transaction.
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        
        }
        $this->createTable('product', [
            'id' => $this->primaryKey()->unsigned(),
            //columns
            'description' => $this->string(45)->notNull(),
            'type' => $this->string(45)->notNull(),
            'price' => $this->decimal(10, 2)->notNull()
            //'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            //'updated' => $this->timestamp()->notNull()          
        ], $tableOptions);

        $this->batchInsert('product', ['description', 'type', 'price'], [
            ['GPU', 'Hardware', '230'],
            ['CPU', 'Hardware', '270'],
            ['RAM', 'Hardware', '120'],
            ['Motherboard', 'Hardware', '190'],
            ['Power supply', 'Hardware', '80'],
            ['Case', 'Hardware', '90'],
            ['Windows', 'Software', '70'],
            ['Microsoft Office', 'Software', '55'],
            ['Adobe Photoshop', 'Software', '80'],
            ['Corel Draw', 'Software', '75'],
        ]);
    }

    public function safeDown()
    {
        $this->delete('product');

        $this->dropTable('product');
    }
    
}
