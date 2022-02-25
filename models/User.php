<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function rules()
    {
        return [
          [['username', 'email'], 'required'],
          [['username', 'email'], 'unique'],
          [['username', 'email'], 'string', 'max' => 255],
          [['email'], 'email'],
          [['username'], 'match', 'pattern' => '?^[a-z0-9_-]+$?i'],
        ];
    }
}