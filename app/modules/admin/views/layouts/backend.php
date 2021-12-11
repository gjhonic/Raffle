<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\BackendAsset;

$nav = array_merge(require(__DIR__ . '/_nav/backend.php'));

BackendAsset::register($this);
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

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><?php echo Yii::$app->name; ?></a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <?php foreach ($nav['main'] as $elem){
                        $isActive = (Yii::$app->controller->id == $elem['controller']) ? 'active' : '';
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?=$isActive?>" href="<?=$elem['href']?>"><?=$elem['label']?>
                            </a>
                        </li>
                    <?php } ?>


                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span><i class="fa fa-database"></i> Базы</span>

                    </h6>
                    <?php foreach ($nav['bases'] as $elem){
                        $isActive = (Yii::$app->controller->id == $elem['controller']) ? 'active' : '';
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?=$isActive?>" href="<?=$elem['href']?>"><?=$elem['label']?>
                            </a>
                        </li>
                    <?php } ?>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span><i class="fa fa-user"></i> Модерация</span>

                    </h6>
                    <?php foreach ($nav['moderations'] as $elem){
                        $isActive = (Yii::$app->controller->id == $elem['controller']) ? 'active' : '';
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?=$isActive?>" href="<?=$elem['href']?>"><?=$elem['label']?>
                            </a>
                        </li>
                    <?php } ?>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span><i class="fa fa-bars"></i> Прочее </span>

                    </h6>
                    <?php foreach ($nav['other'] as $elem){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$elem['href']?>"><?=$elem['label']?>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                'activeItemTemplate' => "<li class='breadcrumb-item active'>{link}</li>\n",
                'homeLink' => [
                    'label' => 'Главная ',
                    'url' => Url::to('/admin/'),
                    'title' => 'Перейти на главную страницу',
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumb', 'style' => ''],
            ]);?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="/media/backend/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="/media/backend/js/dashboard.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
