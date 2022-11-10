<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "lesson".
 *
 * @property int $lessonId
 * @property string|null $title
 * @property string|null $description
 * @property string|null $urlVideo
 * @property int|null $createdAt
 * @property int|null $updatedAt
 *
 * @property UserLesson[] $userLessons
 */
class Lesson extends \yii\db\ActiveRecord
{
    public $userLessonId;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lesson';
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
            [['description'], 'string'],
            [['createdAt', 'updatedAt'], 'integer'],
            ['urlVideo', 'url'],
            [['title', 'urlVideo'], 'string', 'max' => 255],
            [['title', 'description', 'urlVideo'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lessonId' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'urlVideo' => 'Видео',
            'createdAt' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[UserLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserLessons()
    {
        return $this->hasMany(UserLesson::class, ['lessonId' => 'lessonId']);
    }
}
