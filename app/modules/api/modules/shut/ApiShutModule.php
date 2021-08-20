<?php

namespace app\modules\api\modules\shut;

/**
 * api/public module definition class
 */
class ApiShutModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\modules\shut\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->defaultRoute = 'main';
    }
}
