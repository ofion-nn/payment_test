<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%save_transaction_info}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190908_142838_create_save_transaction_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%save_transaction_info}}', [
            'id' => $this->primaryKey(),
            'transact_id' => $this->tinyInteger()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->float(3),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%save_transaction_info}}');
    }
}
