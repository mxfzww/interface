<?php

namespace app\api\controllers;

use yii\web\Controller;
use app\commands\ApiController;
/**
 * Default controller for the `api` module
 */
class BaiduController extends ApiController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}