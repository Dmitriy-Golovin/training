<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */

$this->title = 'Update Lesson: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Уроки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'lessonId' => $model->lessonId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
