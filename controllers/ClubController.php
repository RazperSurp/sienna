<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\club\NewClubForm;
use app\models\club\Club;
use app\models\user\User;

class ClubController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['login', 'logout', 'change-club' ,'reg-member' , 'change-role'], тут указывается только те к которым применять общие правила (просто указать в массиве allow и roles без подмассива)
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-club'],
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['user/login']);
                    }
                    throw new \yii\web\ForbiddenHttpException('У вас нет прав для доступа к этой странице.');
                }
            ],
        ];
    }

    public function actionIndex($id){
        $club = Club::findById($id);
        if(!$club) throw new \yii\web\NotFoundHttpException('Такого клуба не сущесвует');
        return $this->render('index' , ['clubInfo' => $club]);
    }

    public function actionCreateClub(){
        $model = new NewClubForm();
        
        if ($model->load(Yii::$app->request->post())) {
            $club = $model->create();
            if ($club) {
                return $this->redirect(['index', 'id' => $club->id]);
            }
        }
        return $this->render('create-club', ['model' => $model]);

    }
}