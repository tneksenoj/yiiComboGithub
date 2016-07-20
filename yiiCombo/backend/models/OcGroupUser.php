<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oc_group_user".
 *
 * @property string $gid
 * @property string $uid
 */
class OcGroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oc_group_user';
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
            [['gid', 'uid'], 'required'],
            [['gid', 'uid'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'uid' => 'Uid',
        ];
    }
}
