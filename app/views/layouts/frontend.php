<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
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
    <script src="/app/media/frontend/js/jquery.min.js"></script>
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
            <?=$content?>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Title -->
            <section id="search" class="alt">
                    <h2><a href="<?=Yii::$app->homeUrl?>"><?php echo Yii::$app->name; ?>.ru</a></h2>

                    <form method="get" action="<?=Url::to('/search')?>">
                        <?php if(($current_query = Yii::$app->request->get('q')) !== null){ ?>
                            <input type="text" name="q" id="input-search-by-site" placeholder="Вы ищите: <?=$current_query?>" />
                        <?php }else{?>
                            <input type="text" name="q" id="input-search-by-site" placeholder="Поиск" />
                        <?php }?>
                    </form>
            </section>
            
            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2>Меню</h2>
                </header>
                <ul>
                    <?php foreach ($nav['main'] as $elem){
                        $isActive = (Yii::$app->controller->id == $elem['controller']) ? 'active' : '';
                        ?>
                        <li>
                            <a class="nav-link <?=$isActive?>" href="<?=$elem['href']?>"><?=$elem['label']?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>

            <!-- Footer -->
            <footer id="footer">
                <p class="copyright">&copy; gjhonic</p>
            </footer>

        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
