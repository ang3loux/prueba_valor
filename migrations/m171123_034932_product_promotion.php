<?php

use yii\db\Migration;

/**
 * Class m171123_034932_product_promotion
 */
class m171123_034932_product_promotion extends Migration
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
        $this->createTable('product_promotion', [
            'product_id' => $this->integer()->unsigned(),
            'promotion_id' => $this->integer()->unsigned(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            //'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            //'updated' => $this->timestamp()->notNull(),
            'PRIMARY KEY(product_id, promotion_id)',
        ], $tableOptions);

        $this->createIndex('idx_product_promotion_product_id_product', 'product_promotion', 'product_id');
        $this->addForeignKey('fk_product_promotion_product_id_product', 'product_promotion', 'product_id', 'product', 'id', 'restrict', 'cascade');

        $this->createIndex('idx_product_promotion_promotion_id_promotion', 'product_promotion', 'promotion_id');
        $this->addForeignKey('fk_product_promotion_promotion_id_promotion', 'product_promotion', 'promotion_id', 'promotion', 'id', 'restrict', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_product_promotion_product_id_product', 'product_promotion');
        $this->dropIndex('idx_product_promotion_product_id_product', 'product_promotion');
        $this->dropForeignKey('fk_product_promotion_promotion_id_promotion', 'product_promotion');
        $this->dropIndex('idx_product_promotion_promotion_id_promotion', 'product_promotion');
        $this->dropTable('product_promotion');
    }
}
