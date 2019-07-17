<?php

namespace backend\models;

use Yii;
use backend\controllers\ProjectsController;
use yii\httpclient\Client as WebClient;
use backend\models\OcUsers;
use backend\models\OcPreferences;
use backend\models\User;
use common\config\yiicfg;
/**
 * This is the model class for table "requests".
 *
 * @property string $username
 * @property string $projectname
 */
class Requests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'projectname'], 'required'],
            [['username', 'projectname'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'projectname' => 'Projectname',
        ];
    }

    /**
     * @inheritdoc
     * @return RequestsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestsQuery(get_called_class());
    }

    // public function checkOCForUser($uid) {
    //   $query = new Query();
    //   $query ->select('yiicombo.user.id, yiicombo.user.username')
    //           ->from('yiicombo.user')
    //           ->leftJoin('owncloud.oc_users', 'yiicombo.user.username = owncloud.oc_users.uid')
    //           ->where('owncloud.oc_users.uid = ' . $uid );
    //   $command = $query->createCommand();
    //   $data = $command->queryAll();
    //   $model->id = $data[$id]['id'];
    //   $model->username = $data[$id]['username'];
    //   return ( $data != null );
    // }


    /*
    * Function createOwncloudUser takes in a username, 
    * Uses it to find the user and creates ownCloud account for them
    */
    public static function createOwncloudUser($username) 
    { // Gets username and password from yiicombo DB to setup user account for the owncloud server and database. 
      $user = User::findOne(['username' => $username]); // Finds user based on username
      //NOTE: Create user with CURL on owncloud user provisioning API THEN check if share permissions works correctly 
      if( ! OcUsers::find()->where(['uid' => $user->username])->exists() ) //Create new user if they don't already exist 
      { // If there is no existing user under this username, create a new user. 
        // Assign new user a random temporary password and copy in the real password later. 
        $temppass = Yii::$app->security->generateRandomString(); //Generate random temporary password
        $client = new WebClient([
            'responseConfig' => [
                'format' => WebClient::FORMAT_JSON
            ],
          ]);
        $response = $client->createRequest() //Method used to create new HTTP request
        ->setMethod('POST')
        ->setUrl(yiicfg::OCS . 'users')
        ->setData(['userid' => $username, //Setting username for owncloud DB
                    'password' => $temppass, // Make New User's password temporary password
                  ])
        ->setOptions(['timeout' => 5,])
        ->send();
        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);
        if (! $vals[$index['STATUS'][0]]['value'] == "ok") { //If process fails, throw exception
          throw new UserException('Sorry couldn\'t create user on OwnCloud.');
        }
        User::changeUserPasswordOnOwncloud($username); //Overwrites temp password with real password
      }
    }

    public function shareOCFolderWithUser($username, $projectname) {
      $client = new WebClient(
        [
          'responseConfig' => [
            'format' => WebClient::FORMAT_JSON
          ],
        ]);
      //curl -X POST /shares -d path="/Projects/Land" -d shareType=1 -d shareWith="Land"
      $response = $client->createRequest() //Method used to create new HTTP request
        ->setMethod('POST')
        ->setUrl(yiicfg::OCS_SHARE . 'shares')
        ->setData(['path' => '/Projects/' . $projectname, 'shareType' => 0, 'shareWith' => $username,
                  'permissions' => 1,]) //Identitifies which project to share, the user it is being 
        ->setOptions(['timeout' => 5,]) //shared to and the permission level(least by default)
        ->send();
        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);
        if ( $vals[$index['STATUS'][0]]['value'] == "ok") {
          return true;} 
        else {
          return false;}
    }

/*
    public static function deleteUserFromGroup($username, $groupName)
    {
      $client = new WebClient([
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]);

      $response = $client->createRequest()
        ->setMethod('delete')
        ->setUrl(yiicfg::OCS. '/users/' . $username .  '/groups')
        ->setData(['groupid' => $groupName])
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[2]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
    }


    public static function addUserToGroup($username, $groupName)
    {
      Requests::createOwncloudUser($username);

      $client = new WebClient([
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]);

      $response = $client->createRequest()
        ->setMethod('post')
        ->setUrl(yiicfg::OCS. '/users/' . $username .  '/groups')
        ->setData(['groupid' => $groupName])
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[2]['value'] == "ok") {
          return true;
        } else {
          return false;
        }


    }
    */
}