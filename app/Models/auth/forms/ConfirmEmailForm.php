<?php
/**
 * SigninForm
 * Форма аутентификации
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\auth\forms;

use yii\base\Model;
use Yii;

class ConfirmEmailForm extends Model
{
    public $code;

    /**
     * @return array - правила валидации.
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            ['code', 'string', 'max'=>5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
        ];
    }

    public function checkCode(){

        $session = Yii::$app->session;
        if(isset($session['code_confirm'])){
            if($this->code == $session['code_confirm']){
                return true;
            }else{
                $this->addError('code', 'Не верный код');
                $this->code = '';
                return false;
            }
        }
    }
}
