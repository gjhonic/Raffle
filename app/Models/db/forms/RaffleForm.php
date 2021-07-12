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
    public $raffle_id = null;
    public $title;
    public $user_id;
    public $short_description;
    public $description;
    public $date_begin;
    public $date_end;
    public $code;
    public $code_old;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title','short_description', 'description'], 'required'],
            [['short_description'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 5000],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 30],
            [['date_begin', 'date_end'], 'string', 'max' => 20],
            ['code', 'codeUniqueValidate']
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'short_description' => 'Короткое описание',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
            'code' => 'Код',
            'date_begin' => 'Дата начала конкурса',
            'date_end' => 'Дата окончания конкурса',
        ];
    }

    /**
     * Метод валидации code.
     * @param $attribute, $params
     */
    public function codeUniqueValidate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (($this->code !== '') && (Raffle::find()->where(['code' => $this->code])->one() !== null)) {
                $this->addError($attribute, 'Данный код уже занят!');
            }
        }
    }

    /**
     * Метод сохранения конкурса в БД.
     * @return bool
     */
    public function saveRaffle()
    {
        if($this->validate()){
            $raffle = new Raffle();
            $raffle->title = $this->title;
            $raffle->user_id = $this->user_id;
            $raffle->status_id = Raffle::STATUS_ON_CHECK_ID;
            if($this->code === ''){
                $this->code = Raffle::codeGenerate();
            }
            $raffle->code = $this->code;
            $raffle->date_begin = $this->date_begin;
            $raffle->date_end = $this->date_end;
            $raffle->short_description = $this->short_description;
            $raffle->description = $this->description;
            return $raffle->save();
        }
    }

    /**
     * Метод обновления конкурса в БД.
     * @param Raffle $raffle
     * @return bool
     */
    public function updateRaffle(Raffle $raffle)
    {
        if($this->validate()){

            $raffle->title = $this->title;
            $raffle->status_id = Raffle::STATUS_ON_CHECK_ID;
            if($this->code === ''){
                $this->code = Raffle::codeGenerate();
            }
            $raffle->code = $this->code;
            $raffle->date_begin = $this->date_begin;
            $raffle->date_end = $this->date_end;
            $raffle->short_description = $this->short_description;
            $raffle->description = $this->description;

            return $raffle->update();
        }
    }

    /**
     * @param Raffle $raffle
     */
    public function setFromRaffle(Raffle $raffle)
    {
        $this->raffle_id = $raffle->id;
        $this->title = $raffle->title;
        $this->code = $raffle->code;
        $this->user_id = $raffle->user_id;
        $this->short_description = $raffle->short_description;
        $this->description = $raffle->description;
        $this->date_begin = $raffle->date_begin;
        $this->date_end = $raffle->date_end;

    }
}
