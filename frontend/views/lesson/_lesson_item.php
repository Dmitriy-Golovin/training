<?php

use yii\helpers\Html;

?>

<div class="d-flex align-items-center pb-3 pt-3 border-bottom">
	<span><?= $model->title ?></span>

	<?php if (!empty($model->userLessonId)) : ?>

		<svg viewBox="0 0 24 24" width="56" height="56" stroke="green" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 d-block ms-auto"><polyline points="20 6 9 17 4 12"></polyline></svg>

	<?php else : ?>

		<?= Html::a('перейти к уроку', ['lesson/view', 'lessonId' => $model->lessonId], [
			'class' => 'ms-auto d-block btn btn-sm btn-info'
		]) ?>

	<?php endif ?>

</div>