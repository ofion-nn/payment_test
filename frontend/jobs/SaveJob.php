<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 07.09.2019
 * Time: 18:01
 */

namespace frontend\jobs;

use yii;
use yii\base\BaseObject;
use common\models\SaveTransactionInfo;
use common\models\SaveUserPayment;

class SaveJob extends BaseObject implements \yii\queue\JobInterface
{
    public $data ;

    public function execute($queue)
    {
        if(!empty($data) && is_array($data)){
            foreach($data as $dataItem){
                $comissionSum = (int)$dataItem['sum'] * ((int)$dataItem['comission'] / 100);
                $dataItem['sum'] = $dataItem['sum'] + $comissionSum;

                $model = new SaveTransactionInfo();
                $model->transact_id = $dataItem['id'];
                $model->user_id = $dataItem['user_id'];
                $model->sum = $dataItem['sum'];
                if ($model->save()) {
                    $userSum = SaveUserPayment::find()->where(['user_id' => $dataItem['user_id']])->one();
                    if(!$userSum){
                        $userSum = new SaveUserPayment();
                        $userSum->user_id = $dataItem['user_id'];
                        $userSum->sum = $dataItem['sum'];
                        if(!$userSum->save()){
                            error_log(print_r($model->getErrorSummary(1), 1));
                        }
                    }
                    else{
                        $userSum->sum = $userSum->sum + $dataItem['sum'];
                        if(!$userSum->save()){
                            error_log(print_r($model->getErrorSummary(1), 1));
                        }
                    }
                } else {
                    error_log(print_r($model->getErrorSummary(1), 1));
                }
            }
        }
    }

}