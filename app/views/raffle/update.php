<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model object */

$this->title = 'Редактирование конкурса '.$model->title;
?>
<header id="header">
    <h2>Редактирование конкурса <a href="<?=Url::to('/show/').$model->code?>" class="logo"><i><?=$model->title?></i></a></h2>
</header>

<section id="banner">
    <div class="content">
        <?= $this->render('update_form', [
            'model' => $model,
        ]) ?>
    </div>
</section>
