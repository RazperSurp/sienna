<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\club\NewClubForm;

class AdminController extends Controller{
    public function behaviors(){
         return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['user/login'])->send();
                    }
                    throw new \yii\web\ForbiddenHttpException('У вас нет прав для доступа к этой странице.');
                }
            ],
        ];
    }


    public function actionChangePassword(){

    }

    public function actionCreateClub(){
        $model = new NewClubForm();
        
        if ($model->load(Yii::$app->request->post())) {
            $club = $model->create();
            if ($club) {
                return $this->redirect(['club/index', 'id' => $club->id]);
            }
        }
        return $this->render('create-club', ['model' => $model]);

    }

}