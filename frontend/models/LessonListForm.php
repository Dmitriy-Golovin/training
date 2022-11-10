<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Lesson;
use common\models\UserLesson;

class LessonListForm extends Lesson
{
	public $isPassedCourse;

	public function getList()
	{
		$user = \Yii::$app->user->identity;
		$query = Lesson::find()
			->select('lesson.*, uLesson.userLessonId')
			->leftJoin(['uLesson' => 'userLesson'], 'uLesson.userId = ' . $user->userId . ' and uLesson.lessonId = lesson.lessonId');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
				'pageSize' => 30,
			],
        ]);

        $lessonCount = Lesson::find()->count();
		$userLessonCount = UserLesson::find()
			->andWhere(['userId' => $user->userId])
			->count();

        $this->isPassedCourse = ($lessonCount > $userLessonCount)
        	? false
        	: true;

        return $dataProvider;
	}
}