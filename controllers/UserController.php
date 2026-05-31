<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\user\LoginForm;
use app\models\user\RegNewMemberForm;
use app\models\user\User;

class UserController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['login', 'logout', 'change-club' ,'reg-member' , 'change-role'], тут указывается только те к которым применять общие правила (просто указать в массиве allow и roles без подмассива)
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout' ,'change-password' , 'index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-club'],
                        'roles' => ['clubMember'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['reg-member'],
                        'roles' => ['clubPresident' , 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-role'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['search-users'],
                        'roles' => ['@'],
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

    public function actionIndex()
    {
        return $this->render('index', [
            'user' => Yii::$app->user->identity,
        ]);
    }

    public function actionLogin(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->redirect(['index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionRegMember(){
        $model = new RegNewMemberForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if ($user = $model->signup()) return $this->redirect(['user/index']);;
        } else {
            return $this->render('reg-member', ['model' => $model]);
        }
    }

    public function actionSearchUsers($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
        }

        return $this->getUsersByFullname($q, $id);
    }

    protected function getUsersByFullname($q = null , $id = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => []];

        if ($q !== null) {
            $out['results'] = User::findAlikeUserByFullName($q);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::findOne($id)->getFullName()];
        }

        return $out;
    }
}