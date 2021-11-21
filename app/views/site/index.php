<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t("app", "Home page");

?>
<section id="banner">
    <div class="content">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</section>