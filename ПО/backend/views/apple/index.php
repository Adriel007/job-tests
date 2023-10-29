<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    <?= Html::encode($this->title) ?>
</h1>

<p>
    <?= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'color',
        'created_at:datetime',
        'fallen_at:datetime',
        'statusText',
        'size',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}',
        ],
    ],
]);
?>