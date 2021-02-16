<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\Rate;
use Yii;
use yii\validators\RequiredValidator;

class RateController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->getRequest();

        $validator = new RequiredValidator;
        if (!$validator->validate($request->getBodyParam('currency'), $error)) {
            return [
                     "error" => "403",
                     "message" => "validation error",
                     "detail" => $error
                    ];
        }

        $params = [
                    $request->getBodyParam('currency'),
                    ((!empty($request->getBodyParam('rateCurrency')))?$request->getBodyParam('rateCurrency'):"RUR"),
                    ((!empty($request->getBodyParam('rateSum')))?$request->getBodyParam('rateSum'):1)
                  ];

        return Rate::get($params);

    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }
}
