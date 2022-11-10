<?php

namespace frontend\controllers;

use frontend\models\LessonListForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Lesson;
use common\models\UserLesson;

class LessonController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'take-lesson'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'take-lesson' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new LessonListForm();
        $dataProvider = $model->getList();

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($lessonId)
    {
        $model = Lesson::findOne($lessonId);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionTakeLesson($lessonId)
    {
        $user = \Yii::$app->user->identity;

        $existUserLesson = UserLesson::find()
            ->andWhere(['userId' => $user->userId])
            ->andWhere(['lessonId' => $lessonId])
            ->one();

        if (!empty($existUserLesson)) {
            \Yii::$app->session->setFlash('error', 'Вы уже прошли этот урок.');
            return $this->redirect(['view', 'lessonId' => $lessonId]);
        }
        
        $userLesson = new UserLesson();
        $userLesson->userId = $user->userId;
        $userLesson->lessonId = $lessonId;


        if (!$userLesson->save()) {
            \Yii::$app->session->setFlash('error', 'Не удалось сохранить состояние.');
            return $this->redirect(['view', 'lessonId' => $lessonId]);
        }

        $completedQuery = UserLesson::find()
            ->select('lessonId')
            ->andWhere(['userId' => $user->userId]);

        $nextLesson = Lesson::find()
            ->andWhere(['not in', 'lessonId', $completedQuery])
            ->one();

        if (!empty($nextLesson)) {
            return $this->redirect(['view', 'lessonId' => $nextLesson->lessonId]);
        }

        return $this->redirect('index');
    }
}
