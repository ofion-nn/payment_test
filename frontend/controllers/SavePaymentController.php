<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 09.09.2019
 * Time: 15:25
 */

namespace frontend\controllers;

use Yii;
use frontend\jobs\SaveJob;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SavePaymentController extends Controller
{

    private $arResult = [];
    private $arPayment = [];

    protected function actionPrepareMessage()
    {
        $countPayment = random_int(1, 10);
        $arResult = [];
        for ($i = 0; $i < $countPayment; $i++) {
             $this->actionGetPayment();
            $this->arResult[] = $this->arPayment;
        }
        $this->actionSaveRandResult($this->arResult);
        return $arResult;
    }

    protected function actionSaveRandResult($arContent)
    {
        $filePath = realpath(Yii::$app->basePath) . '/uploads/paySystemQueryLog.csv';
        if (file_exists($filePath)) {
            if (is_array($arContent) && !empty($arContent)) {
                $file = fopen($filePath, "a");
                foreach ($arContent as $content) {
                    fputcsv($file, $content);
                }
                fclose($file);
            }
        } else {
            $headers = ['query_id', 'sum', 'comission', 'order_number'];
            $file = fopen($filePath, "w");
            fputcsv($file, $headers);
            fclose($file);
        }
    }


    private function actionGetPayment()
    {
        $this->arPayment = [];
        $this->arPayment['sum'] = random_int(10, 500); // Сумма
        $this->arPayment['commission'] = round($this->actionRandomFloat(0.5, 2), 2);
        $this->arPayment['order_number'] = random_int(1, 20);
    }

    protected function actionRandomFloat($min, $max)
    {
        return ($min + lcg_value() * (abs($max - $min)));
    }

    private function actionCryptoDescription()
    {
        $secretKey = 'First';
        $data = json_encode($this->arResult);
        $encryptedData = Yii::$app->getSecurity()->encryptByPassword($data, $secretKey);
        $hashArr = str_split($encryptedData, 62);
        return $hashArr;
    }

    public function actionSave()
    {
        $this->actionPrepareMessage();
        if (Yii::$app->queue->delay(20)->push(new SaveJob([
            'data' => $this->arResult,
        ]))) {
            return $this->render('index', ['msg' => 'Ok']);
        } else {
            return $this->render('index', ['msg' => 'false']);
        }
    }
}