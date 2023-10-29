<?php

use yii\helpers\Html;

$this->title = 'Create Apple';
$this->params['breadcrumbs'][] = ['label' => 'Apples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    <?= Html::encode($this->title) ?>
</h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>