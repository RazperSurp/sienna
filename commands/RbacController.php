<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    /**
     * Создание ролей и прав (запуск: yii rbac/init)
     */
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $auth->removeAll();
        
        // Права
        $viewClub = $auth->createPermission('viewClub');
        $viewClub->description = 'Просмотр странички клуба';
        $auth->add($viewClub);

        $createEvent = $auth->createPermission('createEvent');
        $createEvent->description = 'Организация ивента';
        $auth->add($createEvent);

        $changeClub = $auth->createPermission('changeClub');
        $changeClub->description = 'Перевод в другой клуб';
        $auth->add($changeClub);

        $manageTokens = $auth->createPermission('manageTokens');
        $manageTokens->description = 'Распоряжение токенами клуба';
        $auth->add($manageTokens);

        $regNewMember = $auth->createPermission('regNewMember');
        $regNewMember->description = 'Зарегистрировать нового участника клуба';
        $auth->add($regNewMember);

        $editClubInfo = $auth->createPermission('editClubInfo');
        $editClubInfo->description = 'Редактировать информации о клубе';
        $auth->add($editClubInfo);

        $regNewClub = $auth->createPermission('regNewClub');
        $regNewClub->description = 'Регистрация нового клуба';
        $auth->add($regNewClub);

        $sendTokens = $auth->createPermission('sendTokens');
        $sendTokens->description = 'Отправить токены на счет клуба';
        $auth->add($sendTokens);

        $changeClubPresident = $auth->createPermission('changeClubPresident');
        $changeClubPresident->description = 'Изменить председателя клуба';
        $auth->add($changeClubPresident);


        // Роли
        $guest = $auth->createRole('guest');
        $guest->description = 'Гость';
        $auth->add($guest);
        $auth->addChild($guest , $viewClub);

        $clubMember = $auth->createRole('clubMember');
        $clubMember->description = 'Участник клуба';
        $auth->add($clubMember);
        $auth->addChild($clubMember , $viewClub);
        $auth->addChild($clubMember , $createEvent);
        $auth->addChild($clubMember , $changeClub);

        $clubPresident = $auth->createRole('clubPresident');
        $clubPresident->description = 'Председатель клуба';
        $auth->add($clubPresident);
        $auth->addChild($clubPresident , $viewClub);
        $auth->addChild($clubPresident , $createEvent);
        $auth->addChild($clubPresident , $manageTokens);
        $auth->addChild($clubPresident , $regNewMember);
        $auth->addChild($clubPresident , $editClubInfo);

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin , $viewClub);
        $auth->addChild($admin , $createEvent);
        $auth->addChild($admin , $regNewMember);
        $auth->addChild($admin , $editClubInfo);
        $auth->addChild($admin , $regNewClub);
        $auth->addChild($admin , $sendTokens);
        $auth->addChild($admin , $changeClubPresident);
        
        return ExitCode::OK;
    }
}