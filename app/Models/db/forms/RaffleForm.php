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
use app\models\db\Raffle;

class RaffleForm extends Model
{
    public $title;
    public $user_id;
    public $short_description;
    public $description;
    public $code;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'code','short_description', 'description'], 'required'],
            [['short_description'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 5000],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 30],
            ['code', 'codeUniqueValidate']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'short_description' => 'Короткое описание',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
            'code' => 'Код',
        ];
    }

    /**
     * Метод валидации code.
     * @param $attribute, $params
     */
    public function codeUniqueValidate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Raffle::find()->where(['code' => $this->code])->one() !== null) {
                $this->addError($attribute, 'Данный код уже занят!');
            }
        }
    }

    /**
     * Метод сохранения конкурса в БД.
     * @return bool
     */
    public function saveRaffle(){
        if($this->validate()){
            $raffle = new Raffle();
            $raffle->title = $this->title;
            $raffle->user_id = $this->user_id;
            $raffle->status_id = Raffle::STATUS_ON_CHECK_ID;
            $raffle->code = $this->code;
            $raffle->short_description = $this->short_description;
            $raffle->description = $this->description;
            return $raffle->save();
        }
    }

}
