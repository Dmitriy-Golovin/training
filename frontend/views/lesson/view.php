<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Урок ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Уроки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="d-flex flex-column">

	<div class="bg-light p-3 mb-3">
		<h3>Название</h3>
		<?= $model->title ?>
	</div>

	<div class="bg-light p-3 mb-3">
		<h3>Описание</h3>
		<?= $model->description ?>
	</div>

	<div class="bg-light p-3 mb-3">
		<iframe class="w-100" height="400"
		    src="<?= $model->urlVideo ?>">
		</iframe>
	</div>

	<?= Html::a('Урок просмотрен', ['take-lesson', 'lessonId' => $model->lessonId], [
        'class' => 'align-self-end btn btn-success',
        'data' => [
            'method' => 'post',
        ],
    ]) ?>

</div>