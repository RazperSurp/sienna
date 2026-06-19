<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\dev\createUser;


class DevController extends Controller{

    public function actionCreateUser(){
        $model = new createUser();

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $user = $model->create();
            Yii::$app->session->setFlash('success', 'Пользователь создан');
        } else {
            return $this->render('createUser', ['model' => $model]);
        }
    }
}