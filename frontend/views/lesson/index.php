<?php

use yii\widgets\ListView;

/** @var yii\web\View $this */

$this->title = 'Уроки';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php if ($model->isPassedCourse) : ?>

	<div class="container d-flex justify-content-center bg-primary rounded-3">
		<h2 class="row p-4 text-white">
			Курс пройден.
		</h2>
	</div>

<?php endif ?>

<?= 
	ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_lesson_item',
		'summary' => false,
		'options' => [
			'tag' => 'div',
			'class' => 'container',
			'id' => 'list-wrapper',
		],
	]); 
?>