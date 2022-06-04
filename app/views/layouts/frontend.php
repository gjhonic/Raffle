<?php

use yii\helpers\Html;
use app\assets\FrontendAsset;

/* @var $this \yii\web\View */
/* @var $content string */

$nav = array_merge(require(__DIR__ . '/_nav/frontend.php'));

if (!Yii::$app->user->isGuest) {
    echo "<input type='hidden' value='" . Yii::$app->user->identity->getCode() . "' id='hidden-input-user-code'>";
    $this->registerJsFile('/media/general/js/access_user.js', ['depends' => [FrontendAsset::className()], 'position' => \yii\web\View::POS_END]);
}

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/media/r.png" type="image/x-icon" />
    <script src="/media/frontend/js/jquery.min.js"></script>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

    <!-- Main -->
    <div id="main">
        <div class="inner">
            <?= $content ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Title -->
            <section id="search" class="alt">
                <h2>
                    <img src="/media/r.png" alt="" style="width: 20px; height: 25px;">
                    <a href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->name; ?>.ru</a></h2>

                <?= $this->renderFile("@app/views/layouts/components/search.php") ?>
            </section>

            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2><?= Yii::t('app', 'Menu') ?></h2>
                </header>
                <ul>
                    <?php foreach ($nav['main'] as $elem) {
                        $isActive = (Yii::$app->controller->id == $elem['controller']) && (Yii::$app->controller->action->id == $elem['action']) ? 'nav-active' : '';
                        ?>
                        <li>
                            <a class="nav-link" id="<?= $isActive ?>" href="<?= $elem['href'] ?>"><?= $elem['label'] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>

            <!-- Footer -->
            <footer id="footer">
                <?= $this->renderFile("@app/views/layouts/components/change-lang.php") ?>
                <br>
                <?= $this->renderFile("@app/views/layouts/components/copyright.php") ?>
            </footer>

        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
