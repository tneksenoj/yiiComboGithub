<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;


class CreateProject extends Model
{
	public $username;
	public $creatorAssociation;
	public $projectName;
	public $projectDescription;
	public $displayImage;
	public $displayDoc;
	public $email;

	public function rules()
	{
		return [
            [['displayImage'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
            [['displayDoc'], 'file', 'extensions' => 'docx, xlsx, txt, rtf, csv', 'maxFiles' => 4],
            [['requestEmail'], 'email', 'required'],
            [['creatorAssociation'], 'string', 'max' => 150], 
            [['projectDescription'], 'string'], 
            [['projectName'], 'unique', 'required'],
            [['requestEmailRepeat'], 'email', 'allowEmpty' => false],
        ];

	}
	public function makeProject()
    {
        if ($this->validate()) {
            foreach ($this->displayImage as $file) {
                $file->saveAs(Yii::$app->basePath.'/web/projects/displayImages/' . $file->baseName . '.' . $file->extension);
            }
            foreach ($this->displayDoc as $file) {
                $file->saveAs(Yii::$app->basePath.'/web/projects/displayDocs/' . $file->baseName . '.' . $file->extension);
            }
        	$project->creatorAssociation = $this->creatorAssociation;
        	$project->projectDescription = $this->projectDescription;
        	$project->projectName = $this->projectName;
            return true;
        } 
        else {
            return false;
        }
        

    }
}


