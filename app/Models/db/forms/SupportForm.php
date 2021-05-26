<?php
/**
 * RaffleForm
 * Форма добавления конкурса
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\db\forms;

use yii\base\Model;
use Yii;
use app\models\db\Support;

class SupportForm extends Model
{
    public $title;
    public $description;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string', 'max' => 5000],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'description' => 'Описание',
        ];
    }

    public function sendSupport(){
        if($this->validate()){
            $support = new Support();
            $support->title = $this->title;
            $support->user_id = Yii::$app->user->identity->id;
            $support->status = 0;
            $support->description = $this->description;
            return $support->save();
        }
    }
}