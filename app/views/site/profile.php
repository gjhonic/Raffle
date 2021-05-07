<?php

/* @var $user object */

use yii\helpers\Html;

$this->title = 'Профиль '.$user->username;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <table>
        <tr>
            <td>
                Имя
            </td>
            <td>
                <?=$user->name?>
            </td>
        </tr>
        <tr>
            <td>
                Фамилия
            </td>
            <td>
                <?=$user->surname?>
            </td>
        </tr>
        <tr>
            <td>
                Код
            </td>
            <td>
                <?=$user->code?>
            </td>
        </tr>
    </table>
</div>
