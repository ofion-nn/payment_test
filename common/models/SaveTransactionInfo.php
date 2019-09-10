<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "save_transaction_info".
 *
 * @property int $id
 * @property int $transact_id
 * @property int $user_id
 * @property double $sum
 */
class SaveTransactionInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'save_transaction_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transact_id', 'user_id'], 'required'],
            [['transact_id', 'user_id'], 'integer'],
            [['sum'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transact_id' => 'Transact ID',
            'user_id' => 'User ID',
            'sum' => 'Sum',
        ];
    }
}
