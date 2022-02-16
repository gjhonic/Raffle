<?php

namespace app\modules\api\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class MenuApiWidget extends Widget
{
    /**
     * Разделы модуля API
     * @return array
     */
    private static function navigations(): array
    {
        return [
            [
                'label' => 'Log use API',
                'href' => Url::to('/api/use'),
                'controller' => 'site'
            ],
            [
                'label' => 'Dock public API',
                'href' => Url::to('/api'),
                'controller' => 'site'
            ],
            [
                'label' => 'Dock private API',
                'href' => Url::to('/api/shut'),
                'controller' => 'site'
            ],
        ];
    }

    public function run()
    {
        return $this->render('menu', [
            'navigations' => self::navigations(),
        ]);
    }
}