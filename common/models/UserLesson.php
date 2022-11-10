<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "userLesson".
 *
 * @property int $userLessonId
 * @property int|null $userId
 * @property int|null $lessonId
 * @property int|null $createdAt
 * @property int|null $updatedAt
 *
 * @property Lesson $lesson
 * @property User $user
 */
class UserLesson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userLesson';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                'value' => time(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'lessonId'], 'integer'],
            [['userId', 'lessonId'], 'required'],
            [['lessonId'], 'exist', 'skipOnError' => false, 'targetClass' => Lesson::class, 'targetAttribute' => ['lessonId' => 'lessonId']],
            [['userId'], 'exist', 'skipOnError' => false, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userLessonId' => 'User Lesson ID',
            'userId' => 'User ID',
            'lessonId' => 'Lesson ID',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Lesson]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::class, ['lessonId' => 'lessonId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'userId']);
    }
}
