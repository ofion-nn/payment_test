<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "save_user_payment".
 *
 * @property int $id
 * @property int $user_id
 * @property double $sum
 */
class SaveUserPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'save_user_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
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
            'user_id' => 'User ID',
            'sum' => 'Sum',
        ];
    }
}
