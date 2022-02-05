<?php

use yii\helpers\Url;

?>

<div class="filters-raffles">
    <div id="box-filter">
        <form method="get" action="<?= Url::to('/raffle/index') ?>">
            <div class="row">
                <div class="col-3 col-12-small">
                    <p>
                        <select name="filter_date">
                            <option value="new" selected>
                                <?= Yii::t('app', 'By date') ?>
                                : <?= Yii::t('app', 'New first') ?>
                            </option>

                            <option value="old">
                                <?= Yii::t('app', 'By date') ?>:
                                <?= Yii::t('app', 'Old first') ?>
                            </option>

                            <option value="0">
                                <?= Yii::t('app', 'By date') ?>:
                                <?= Yii::t('app', 'Ignore') ?>
                            </option>
                        </select>
                    </p>
                </div>
                <div class="col-3 col-12-small">
                    <p>
                        <select name="filter_abc">
                            <option value="abc" selected>
                                <?=Yii::t('app', 'Alphabetically')?>:
                                <?=Yii::t('app', 'Abc')?>...
                            </option>

                            <option value="">
                                <?=Yii::t('app', 'Alphabetically')?>:
                                <?=Yii::t('app', 'Zyx')?>...
                            </option>

                            <option value="0" selected>
                                <?=Yii::t('app', 'Alphabetically')?>:
                                <?= Yii::t('app', 'Ignore') ?>
                            </option>
                        </select>
                    </p>
                </div>
                <div class="col-3 col-12-small">
                    <p>
                        <select name="filter_group">
                            <option value="user">
                                <?=Yii::t('app', 'Group')?>:
                                <?=Yii::t('app', 'By author')?>
                            </option>

                            <option value="0" selected>
                                <?=Yii::t('app', 'Group')?>:
                                <?=Yii::t('app', 'Do not group')?>
                            </option>
                        </select>
                    </p>
                </div>
                <div class="col-3 col-12-small">
                    <p>
                        <button class="button primary fit"><?= Yii::t('app', 'Apply') ?></button>
                    </p>
                </div>
            </div>
        </form>
    </div>

    <div id="box-search">
        <form method="get" action="<?= Url::to('/search') ?>">
            <div class="row">
                <div class="col-6 col-12-small">
                        <input type="text" name="q" id="input-search-by-site"
                               placeholder="<?= Yii::t('app', 'Search') ?>"/>
                </div>
                <div class="col-6 col-12-small">
                    <button class="button primary fit"><?= Yii::t("app", "Search") ?></button>
                </div>
                <span><?= Yii::t("app/note", "I will search for matches of contest media, users and tags") ?></span>
            </div>
        </form>
    </div>
</div>
