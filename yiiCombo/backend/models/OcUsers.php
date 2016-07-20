<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oc_users".
 *
 * @property string $uid
 * @property string $displayname
 * @property string $password
 */
class OcUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oc_users';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('ocdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'displayname'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'displayname' => 'Displayname',
            'password' => 'Password',
        ];
    }

    public function getYiiUsers()
    {
        return $this->hasOne(User::className(), ['username' => 'uid']);
    }
}
