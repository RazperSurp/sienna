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

}