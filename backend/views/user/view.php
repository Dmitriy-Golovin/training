<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->userId;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'userId' => $model->userId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'userId' => $model->userId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userId',
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'value' => function(User $model) {
                    $role = $model->getUserRoleStr();
                    return array_key_exists($role, User::roleLabels()) ? User::roleLabels()[$role] : null;
                }
            ],
            'createdAt:datetime',
        ],
    ]) ?>

</div>
