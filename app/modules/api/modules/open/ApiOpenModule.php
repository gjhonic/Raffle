<?php

namespace app\modules\api\modules\open;

/**
 * api/public module definition class
 */
class ApiOpenModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\modules\open\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->defaultRoute = 'main';
        $this->layout = '/../../modules/api/modules/open/views/layouts/main';
    }
}
