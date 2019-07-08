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

    public $file;
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
            [['Description', 'System'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 1],
            ['logo', 'default', 'value' => '/../../../common/images/uploadFile.png'],
            [['Name', 'logo'], 'string', 'max' => 255],
            [['Name'], function ($attribute, $params){
                  if(preg_match('/\s/', $this->$attribute)) {
                    //error_log("EL1");
                    $this->addError($this->$attribute, 'Sorry, spaces are not allowed in project names.');
                  }
                }],
                [['logo'], function ($attribute, $params){
                    if(preg_match('/\s/', $this->$attribute)) {
                      //
                      $this->addError($this->$attribute, 'Sorry, spaces are not allowed in file names.');
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
            'PID' => 'ID', //Changed from "Pid" to "Id"; More users will understand this
            'Name' => 'Name',
            'Description' => 'Description',
            'file' => 'Logo',
            'System' => 'System',
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
