<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

//This class is used for file uploading rules

class UploadForm extends Model
{
    public $file;



    public function rules()
    {
        return [
            [['file'], 'file'],
        ];

    }
}
?>
