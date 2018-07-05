<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invoice`.
 */
class m180705_161235_create_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'from' => $this->string()->notNull(),
            'where' => $this->string()->notNull(),
            'recipient' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('invoice');
    }
}
