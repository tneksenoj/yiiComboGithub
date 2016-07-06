<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property integer $PID
 * @property string $Name
 * @property string $Description
 *
 * @property Credentials[] $credentials
 * @property User[] $us
 * @property Sitedata[] $sitedatas
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description'], 'string'],
            [['Name'], 'string', 'max' => 255],
            [['Name'], function ($attribute, $params){
                  if(preg_match('/\s/', $this->$attribute)) {
                    //error_log("EL1");
                    $this->addError($this->$attribute, 'Sorry, spaces are not allowed in project names.');
                  }
                  if(Projects::find()->where(['Name' => $this->$attribute])->exists()) {
                    //error_log("EL2");
                    $this->addError($this->$attribute, 'Sorry, that project name is already in use.');
                  }
                  if(Yii::$app->webdavFs->has(Yii::$app->params['OC_files'] . $this->$attribute)){
                    //error_log("EL3");
                    $this->addError($this->$attribute, 'Sorry, that name is already in use on the project server.');
                  }
                }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PID' => 'Pid',
            'Name' => 'Name',
            'Description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credentials::className(), ['PID' => 'PID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasMany(User::className(), ['id' => 'UID'])->viaTable('credentials', ['PID' => 'PID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitedatas()
    {
        return $this->hasMany(Sitedata::className(), ['PID' => 'PID']);
    }
}
