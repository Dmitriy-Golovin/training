<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m221110_133346_createAadminUser
 */
class m221110_133346_createAdminUser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();

        $user->username = \Yii::$app->params['adminUsername'];
        $user->email = \Yii::$app->params['adminEmail'];
        $user->setPassword(\Yii::$app->params['adminPassword']);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221110_133346_createAadminUser cannot be reverted.\n";

        return false;
    }
}
