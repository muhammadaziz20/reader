<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Audios */

$this->title = 'Create Audio';
$this->params['breadcrumbs'][] = ['label' => 'Audios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
