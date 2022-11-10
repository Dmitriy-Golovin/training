<?php

use common\models\Lesson;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\LessonSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Уроки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить урок', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            'lessonId',
            'title',
            [
                'attribute' => 'description',
                'value' => function($model) {
                    return (strlen($model->description) > 100)
                        ? mb_substr($model->description, 0, 100) . ' ...'
                        : $model->description;
                }
            ],
            'urlVideo',
            'createdAt:datetime',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Lesson $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'lessonId' => $model->lessonId]);
                 }
            ],
        ],
    ]); ?>


</div>
