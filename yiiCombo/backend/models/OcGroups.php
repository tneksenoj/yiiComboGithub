<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oc_groups".
 *
 * @property string $gid
 */
class OcGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oc_groups';
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
            [['gid'], 'required'],
            [['gid'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
        ];
    }
}
