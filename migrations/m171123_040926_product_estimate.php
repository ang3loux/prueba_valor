<?php

use yii\db\Migration;

/**
 * Class m171123_040926_product_estimate
 */
class m171123_040926_product_estimate extends Migration
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
        $this->createTable('product_estimate', [
            'product_id' => $this->integer()->unsigned(),
            'estimate_id' => $this->integer()->unsigned(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated' => $this->timestamp()->notNull(),
            'PRIMARY KEY(product_id, estimate_id)',
        ], $tableOptions);

        $this->createIndex('idx_product_estimate_product_id_product', 'product_estimate', 'product_id');
        $this->addForeignKey('fk_product_estimate_product_id_product', 'product_estimate', 'product_id', 'product', 'id', 'restrict', 'cascade');

        $this->createIndex('idx_product_estimate_estimate_id_estimate', 'product_estimate', 'estimate_id');
        $this->addForeignKey('fk_product_estimate_estimate_id_estimate', 'product_estimate', 'estimate_id', 'estimate', 'id', 'restrict', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_product_estimate_product_id_product', 'product_estimate');
        $this->dropIndex('idx_product_estimate_product_id_product', 'product_estimate');
        $this->dropForeignKey('fk_product_estimate_estimate_id_estimate', 'product_estimate');
        $this->dropIndex('idx_product_estimate_estimate_id_estimate', 'product_estimate');
        $this->dropTable('product_estimate');
    }
}
