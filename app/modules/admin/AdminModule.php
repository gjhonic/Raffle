<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class AdminModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->defaultRoute = 'main';

        $this->layout = '../../../../views/layouts/backend';

        // custom initialization code goes here


    }
}
