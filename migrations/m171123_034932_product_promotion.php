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
        $this->createTable('product_promotion', [
            'product_id' => $this->integer()->unsigned(),
            'promotion_id' => $this->integer()->unsigned(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            //'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            //'updated' => $this->timestamp()->notNull(),
            'PRIMARY KEY(product_id, promotion_id)',
        ], $tableOptions);

        $this->batchInsert('product_promotion', ['product_id', 'promotion_id', 'quantity', 'price'], [
            ['1', '1', '1', '230'],
            ['2', '1', '1', '270'],
            ['3', '1', '1', '120'],
            ['4', '1', '1', '190'],
            ['5', '1', '1', '80'],
            ['6', '1', '1', '90'],
            ['7', '2', '1', '70'],
            ['9', '2', '1', '80'],
            ['10', '2', '1', '75'],
        ]);

        $this->createIndex('idx_product_promotion_product_id_product', 'product_promotion', 'product_id');
        $this->addForeignKey('fk_product_promotion_product_id_product', 'product_promotion', 'product_id', 'product', 'id', 'restrict', 'cascade');

        $this->createIndex('idx_product_promotion_promotion_id_promotion', 'product_promotion', 'promotion_id');
        $this->addForeignKey('fk_product_promotion_promotion_id_promotion', 'product_promotion', 'promotion_id', 'promotion', 'id', 'restrict', 'cascade');
    }

    public function safeDown()
    {
        $this->delete('product_promotion');

        $this->dropForeignKey('fk_product_promotion_product_id_product', 'product_promotion');
        $this->dropIndex('idx_product_promotion_product_id_product', 'product_promotion');
        $this->dropForeignKey('fk_product_promotion_promotion_id_promotion', 'product_promotion');
        $this->dropIndex('idx_product_promotion_promotion_id_promotion', 'product_promotion');
        $this->dropTable('product_promotion');
    }
}
