<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Apple Details';
$this->params['breadcrumbs'][] = ['label' => 'Apples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    <?= Html::encode($this->title) ?>
</h1>

<p>
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'color',
        'created_at:datetime',
        'fallen_at:datetime',
        'statusText',
        'size',
    ],
]) ?>