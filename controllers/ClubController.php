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
                    [
                        'allow' => true,
                        'actions' => ['search-clubs'],
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

    public function actionSearchClubs($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
        }

        return $this->getClubsByName($q, $id);
    }

    protected function getClubsByName($q = null , $id = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => []];

        if ($q !== null) {
            $out['results'] = Club::findAlikeClubsByName($q);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Club::findOne($id)->name];
        }

        return $out;
    }

    public function actionJoin(){
    $model = new \app\models\user\BankForm();
    if ($model->load(Yii::$app->request->post())) {
        if ($model->joinClub(1)) { 
            Yii::$app->session->setFlash('success', 'Вы успешно сменили клуб!');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при смене клуба.');
        }
    }
    $clubsList = \yii\helpers\ArrayHelper::map(\app\models\club\Club::find()->all(), 'id', 'name');
    return $this->render('join', [
        'model' => $model,
        'clubsList' => $clubsList,
    ]);
}
    public function actionDeleteClub(){
    $model = new \app\models\user\BankForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $club = \app\models\club\Club::findOne($model->clubId);
        if ($club && $club->dismiss()) {
            Yii::$app->session->setFlash('success', 'Клуб успешно удалён.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось распустить выбранный клуб.');
        }
    }
    $clubsList = \yii\helpers\ArrayHelper::map(\app\models\club\Club::find()->all(), 'id', 'name');
    return $this->render('delete-club', [
        'model' => $model,
        'clubsList' => $clubsList,
    ]);
}


}