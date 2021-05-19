<?php

use yii\db\Migration;
use app\models\db\UserAtribute;

/**
 * Class m210422_052139_user_attribute
 */
class m210422_052139_create_user_attribute extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_attribute', [
            'id' => $this->primaryKey(),
            'title' => $this->string(20)->unique()->notNull(),
            'description' => $this->string(255),
            'type' => $this->string(10)->notNull(),
        ]);

        $this->createIndex(
            'idx-user_status-id',
            'user_attribute',
            'id'
        );

        $this->addDataToDB();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-user_attribute-id',
            'user_attribute'
        );

        $this->dropTable('user_attribute');
    }

    /**
     * Метод добавляет в БД атибуты
     */
    private function addDataToDB()
    {
        $avatar_img = new UserAtribute();
        $avatar_img->title = "ava_img";
        $avatar_img->description = "Изображения профиля";
        $avatar_img->save();

        $about = new UserAtribute();
        $about->title = "about";
        $about->description = "Информация о пользователе";
        $about->save();

        //Соц.сети
        $link_vk = new UserAtribute();
        $link_vk->title = "vk_link";
        $link_vk->description = "Ссылка на Вконтакте";
        $link_vk->type = 'social link';
        $link_vk->save();

        $link_vk_confirm = new UserAtribute();
        $link_vk_confirm->title = "vk_confirm_link";
        $link_vk_confirm->description = "Ссылка на Вконтакте подтверждена";
        $link_vk_confirm->type = 'social link';
        $link_vk_confirm->save();

        $link_yt = new UserAtribute();
        $link_yt->title = "yt_link";
        $link_yt->description = "Ссылка на YouTube";
        $link_yt->type = 'social link';
        $link_yt->save();

        $link_yt_confirm = new UserAtribute();
        $link_yt_confirm->title  = "yt_confirm_link";
        $link_yt_confirm->description = "Ссылка на YouTube подтверждена";
        $link_yt_confirm->type = 'social link';
        $link_yt_confirm->save();

        $link_fb = new UserAtribute();
        $link_fb->title = "fb_link";
        $link_fb->description = "Ссылка на FaceBook";
        $link_fb->type = 'social link';
        $link_fb->save();

        $link_fb_confirm = new UserAtribute();
        $link_fb_confirm->title = "fb_confirm_link";
        $link_fb_confirm->description = "Ссылка на FaceBook подтверждена";
        $link_fb_confirm->type = 'social link';
        $link_fb_confirm->save();

        $link_ig = new UserAtribute();
        $link_ig->title = "ig_link";
        $link_ig->description = "Ссылка на Instagram";
        $link_ig->type = 'social link';
        $link_ig->save();

        $link_ig_confirm = new UserAtribute();
        $link_ig_confirm->title = "ig_confirm_link";
        $link_ig_confirm->description = "Ссылка на Instagram подтверждена";
        $link_ig_confirm->type = 'social link';
        $link_ig_confirm->save();
    }
}
