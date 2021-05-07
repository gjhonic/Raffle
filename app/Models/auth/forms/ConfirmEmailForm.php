<?php
/**
 * SigninForm
 * Форма аутентификации
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\auth\forms;

use yii\base\Model;

class ConfirmEmailForm extends Model
{
    public $code;

    /**
     * rules - метод возвращает правила валидации.
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
}
