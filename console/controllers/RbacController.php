<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use yii\console\ExitCode;
use yii\helpers\Console;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $guest = $auth->createRole('guest');
        $guest->description = 'Гость';
        $auth->add($guest);

        $user = $auth->createRole('user');
        $guest->description = 'Пользователь';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $guest->description = 'Админ';
        $auth->add($admin);
        $auth->addChild($admin, $user);

        $this->setAdminRoleForUser('admin');
   }

   protected function setAdminRoleForUser($admin){

        if (empty($admin) || !is_string($admin)) {
            $this->stdout("Param 'admin' must be set!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = (new User())->findByUsername($admin);

        if (empty($user)) {
            $this->stdout("User witch username:'$admin' is not found!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $auth = Yii::$app->authManager;

        $role = $auth->getRole('admin');

        $auth->revokeAll($user->userId);

        $auth->assign($role, $user->userId);

        $this->stdout("Done!\n", Console::BOLD);
        return ExitCode::OK;
   }
}