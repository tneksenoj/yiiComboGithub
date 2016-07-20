<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oc_preferences".
 *
 * @property string $userid
 * @property string $appid
 * @property string $configkey
 * @property string $configvalue
 */
class OcPreferences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oc_preferences';
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
            [['userid', 'appid', 'configkey'], 'required'],
            [['configvalue'], 'string'],
            [['userid', 'configkey'], 'string', 'max' => 64],
            [['appid'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'Userid',
            'appid' => 'Appid',
            'configkey' => 'Configkey',
            'configvalue' => 'Configvalue',
        ];
    }
}
