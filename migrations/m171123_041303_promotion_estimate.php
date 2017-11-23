<?php

use yii\db\Migration;

/**
 * Class m171123_041303_promotion_estimate
 */
class m171123_041303_promotion_estimate extends Migration
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
    //     echo "m171123_021643_promotion cannot be reverted.\n";

    //     return false;
    // }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        
        }
        $this->createTable('promotion_estimate', [
            'promotion_id' => $this->integer()->unsigned(),
            'estimate_id' => $this->integer()->unsigned(),
            'price' => $this->decimal(10, 2)->notNull(),
            //'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            //'updated' => $this->timestamp()->notNull(),
            'PRIMARY KEY(promotion_id, estimate_id)',
        ], $tableOptions);

        $this->createIndex('idx_promotion_estimate_promotion_id_promotion', 'promotion_estimate', 'promotion_id');
        $this->addForeignKey('fk_promotion_estimate_promotion_id_promotion', 'promotion_estimate', 'promotion_id', 'promotion', 'id', 'restrict', 'cascade');

        $this->createIndex('idx_promotion_estimate_estimate_id_estimate', 'promotion_estimate', 'estimate_id');
        $this->addForeignKey('fk_promotion_estimate_estimate_id_estimate', 'promotion_estimate', 'estimate_id', 'estimate', 'id', 'restrict', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_promotion_estimate_promotion_id_promotion', 'promotion_estimate');
        $this->dropIndex('idx_promotion_estimate_promotion_id_promotion', 'promotion_estimate');
        $this->dropForeignKey('fk_promotion_estimate_estimate_id_estimate', 'promotion_estimate');
        $this->dropIndex('idx_promotion_estimate_estimate_id_estimate', 'promotion_estimate');
        $this->dropTable('promotion_estimate');
    }
}
