<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\FrontendAsset;

$nav = array_merge(require(__DIR__ . '/_nav/frontend.php'));

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <h1><a href="index.html"><?php echo Yii::$app->name; ?></a></h1>
        <nav class="links">
            <ul>
                <?php foreach ($nav['main'] as $elem){
                    $isActive = (Yii::$app->controller->id == $elem['controller']) ? 'active' : '';
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?=$isActive?>" href="<?=$elem['href']?>"><?=$elem['label']?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <nav class="main">
            <ul>
                <li class="search">
                    <a class="fa-search" href="#search">Search</a>
                    <form id="search" method="get" action="#">
                        <input type="text" name="query" placeholder="Search" />
                    </form>
                </li>
                <li class="menu">
                    <a class="fa-bars" href="#menu">Menu</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Menu -->
    <section id="menu">

        <!-- Search -->
        <section>
            <form class="search" method="get" action="#">
                <input type="text" name="query" placeholder="Search" />
            </form>
        </section>

        <!-- Links -->
        <section>
            <ul class="links">
                <?php foreach ($nav['main'] as $elem){
                    $isActive = (Yii::$app->controller->id == $elem['controller']) ? 'active' : '';
                    ?>
                    <li>
                        <a class="<?=$isActive?>" href="<?=$elem['href']?>"><?=$elem['label']?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </section>

    </section>

    <!-- Main -->
    <div id="main">
        <?= $content ?>
    </div>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
