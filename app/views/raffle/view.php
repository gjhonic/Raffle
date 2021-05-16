<?php

/* @var $user object */

$this->title = $model->title;
?>
<div class="site-profile">
        <article class="post">
            <header>
                <div class="title">
                    <h2><a href="single.html"><?=$model->title?></a></h2>
                </div>
                <div class="meta">
                    <time class="published" datetime="2015-11-01"><?=date('j F, Y', $model->updated_at)?></time>
                    <!--<a href="#" class="author"><span class="name">Jane Doe</span><img src="images/avatar.jpg" alt=""></a>-->
                </div>
            </header>
            <p><?=$model->description?></p>
            <footer>
            </footer>
        </article>
</div>
