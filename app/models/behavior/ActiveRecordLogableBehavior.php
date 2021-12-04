<?php

namespace app\models\behavior;

use yii\db\ActiveRecord;
use yii;
use app\models\behavior\ActiveRecordCreateLog;
use app\models\behavior\ActiveRecordChangeLog;
use app\models\base\User;

class ActiveRecordLogableBehavior extends \yii\base\Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function beforeUpdate($event)
    {
        $user = Yii::$app->user->identity ?? null;

        $newattributes = $this->owner->getAttributes();
        $oldattributes = $this->owner->getOldAttributes();

        // compare old and new
        foreach ($newattributes as $name => $value) {
            if (($name != 'created_at') && ($name != 'updated_at') && ($name != 'id')) {
                if (!empty($oldattributes)) {
                    $old = $oldattributes[$name];
                } else {
                    $old = '';
                }
                if ($name == 'is_distributing') {
                    return;
                }

                if ($value != $old) {
                    //$changes = $name . ' ('.$old.') => ('.$value.'), ';

                    $log = new ActiveRecordChangeLog();
                    $log->old_value = strval($old);
                    $log->new_value = strval($value);
                    $log->model = get_class($this->owner);
                    $log->model_id = $this->owner->getPrimaryKey();
                    $log->field = $name;
                    $log->user_id = $user->id ?? 0;
                    $log->save();
                }
            }
        }
    }

    public function afterInsert($event)
    {
        $attributes = $this->owner->getAttributes();
        $user = Yii::$app->user->identity ?? null;

        $log = new ActiveRecordCreateLog();
        $log->action = ActiveRecordCreateLog::ACTION_CREATE;
        $log->model = get_class($this->owner);
        $log->model_id = $this->owner->getPrimaryKey();
        $log->user_id = $user->id ?? 0;
        $log->save();

        foreach ($attributes as $name => $value) {
            if (($name != 'created_at') && ($name != 'updated_at') && ($name != 'id')) {
                $log = new ActiveRecordChangeLog();
                $log->old_value = null;
                $log->new_value = strval($value);
                $log->model = get_class($this->owner);
                $log->model_id = $this->owner->getPrimaryKey();
                $log->field = $name;
                $log->user_id = $user->id ?? 0;
                $log->save();
            }
        }

    }

    public function afterDelete($event)
    {
        $attributes = $this->owner->getAttributes();

        $user = Yii::$app->user->identity ?? null;

        $log = new ActiveRecordCreateLog();
        $log->action = ActiveRecordCreateLog::ACTION_DELETE;
        $log->model = get_class($this->owner);
        $log->model_id = $this->owner->getPrimaryKey();
        $log->user_id = $user->id ?? 0;
        $log->save();

        foreach ($attributes as $name => $value) {
            if (($name != 'created_at') && ($name != 'updated_at') && ($name != 'id')) {
                $log = new ActiveRecordChangeLog();
                $log->old_value = strval($value);
                $log->new_value = null;
                $log->model = get_class($this->owner);
                $log->model_id = $this->owner->getPrimaryKey();
                $log->field = $name;
                $log->user_id = $user->id ?? 0;
                $log->save();
            }
        }
    }
}