<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%save_user_payment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190909_053738_create_save_user_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%save_user_payment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->float(3),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%save_user_payment}}');
    }
}
