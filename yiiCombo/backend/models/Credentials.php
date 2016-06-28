<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "credentials".
 *
 * @property integer $UID
 * @property integer $PID
 * @property integer $ACL
 *
 * @property User $u
 * @property Projects $p
 */
class Credentials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'credentials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UID', 'PID'], 'required'],
            [['UID', 'PID', 'ACL'], 'integer'],
            [['UID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['UID' => 'id']],
            [['PID'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['PID' => 'PID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'UID' => 'Uid',
            'PID' => 'Pid',
            'ACL' => 'Acl',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'UID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP()
    {
        return $this->hasOne(Projects::className(), ['PID' => 'PID']);
    }
}
