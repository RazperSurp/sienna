<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\event\Event;
use app\models\club\NewClubForm;
use app\models\admin\CreateEvent;
use app\models\admin\CloseEvent;
use app\models\admin\ChangePassword;

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
        $model = new ChangePassword();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('success', 'Пароль пользователя изменен');
            }
        }
        return $this->render('change-password', ['model' => $model]);
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

    public function actionCreateEvent(){
        $model = new CreateEvent();
        if ($model->load(Yii::$app->request->post())) {
            $event = $model->create();
            if ($event) {
                Yii::$app->session->setFlash('success', 'Мероприятие создано');
                return $this->redirect(['club/index', 'id' => $event->club_id]);
            }
        }
        return $this->render('create-event', ['model' => $model]);

    }

    public function actionCloseEvent(){
        $model = new CloseEvent();
        if ($model->load(Yii::$app->request->post())) {
            $event = $model->close();
            if ($event) {
                Yii::$app->session->setFlash('success', 'Мероприятие завершено');
                return $this->redirect(['club/index', 'id' => $event->club_id]);
            }
        }
        return $this->render('close-event', ['model' => $model]);

    }

    public function actionSearchEvents($q = null, $id = null , $type = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
        }

        return $this->getEventsByName($q, $id , $type);
    }

    protected function getEventsByName($q = null , $id = null , $type = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => []];

        if ($q !== null) {
            $out['results'] = Event::findAlikeByName($q , $type);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Club::findOne($id)->name];
        }

        return $out;
    }
    public function actionTransferUser() {
        $model = new AdminTransferForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findOne($model->userId);
            if ($user && $user->changeClub($model->clubId)) {
                Yii::$app->session->setFlash('success', "Пользователь успешно переведен в новый клуб!");
                return $this->refresh();
            } else {
                Yii::$app->session-setFlash('error', 'Не удалось перевести пользователя');
            }
        }
        return $this->render('transfer-user', [
            'model' => $model,
        ]);
    }
    public function actionBank(){
    $model = new \app\models\user\BankForm();
    $model->clubId = Yii::$app->user->isGuest ? 1 : Yii::$app->user->identity->club_id; 
    if ($model->load(Yii::$app->request->post())) {
        if ($model->executeTransaction()) {
            Yii::$app->session->setFlash('success', 'Операция по счету клуба успешно выполнена!');
            return $this->refresh();
        } else {
            Yii::$app->session->setFlash('error', 'Произошла ошибка при выполнении банковской операции.');
        }
    }
    $clubsList = \yii\helpers\ArrayHelper::map(\app\models\club\Club::find()->all(), 'id', 'name');
    return $this->render('bank', [
        'model' => $model,
        'clubsList' => $clubsList, 
    ]);
    }

}