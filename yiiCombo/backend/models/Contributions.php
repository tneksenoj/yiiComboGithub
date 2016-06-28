<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contributions".
 *
 * @property integer $UID
 * @property integer $DID
 *
 * @property User $u
 * @property Sitedata $d
 */
class Contributions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contributions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UID', 'DID'], 'required'],
            [['UID', 'DID'], 'integer'],
            [['UID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['UID' => 'id']],
            [['DID'], 'exist', 'skipOnError' => true, 'targetClass' => Sitedata::className(), 'targetAttribute' => ['DID' => 'DID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'UID' => 'Uid',
            'DID' => 'Did',
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
    public function getD()
    {
        return $this->hasOne(Sitedata::className(), ['DID' => 'DID']);
    }
}
