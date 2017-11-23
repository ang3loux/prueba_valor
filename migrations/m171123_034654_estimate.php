<?php

use yii\db\Migration;

/**
 * Class m171123_034654_estimate
 */
class m171123_034654_estimate extends Migration
{
    /**
     * @inheritdoc
     */
    // public function safeUp()
    // {

    // }

    /**
     * @inheritdoc
     */
    // public function safeDown()
    // {
    //     echo "m171123_021643_product cannot be reverted.\n";

    //     return false;
    // }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        
        }
        $this->createTable('estimate', [
            'id' => $this->primaryKey()->unsigned(),
            //columns
            'seller_name' => $this->string(45)->notNull(),
            'client_name' => $this->string(45)->notNull(),
            'ruc' => $this->string(45)->notNull()->unique(),            
            'total' => $this->decimal(10, 2)->notNull(),
            'tax' => $this->decimal(10, 2)->notNull(),
            'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated' => $this->timestamp()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('estimate');
    }
}
