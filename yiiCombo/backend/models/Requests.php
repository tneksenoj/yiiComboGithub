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

    public static function createOwncloudUser($username) //Owncloud database
    {
      // Get Information about user from Yiicombo
      //$user = User::find()->where(['username' => $username])->one();
      // This gets a user from the Yiicombo database.  This username and password will be used
      // to set the username and password on the owncloud side of things.
      $user = User::findOne(['username' => $username]); // Finding user based on username

      // Now, search the owncloud database for the same user, if they don't exist, create that user
      // and give them the same username and password as is in the Yiicombo database.
      if( ! OcUsers::find()->where(['uid' => $user->username])->exists() ) //Create user with CURL on owncloud user provisioning API THEN check if share permissions works correctly 
      {//If user doesn't exist, create a new user
        // NEW: Use the Owncloud User API and webclient interface to create a user with the 
        // username passed into this function.  Give the user a temporary random passworkd
        // that will be reset shortly. 
        $temppass = Yii::$app->security->generateRandomString();
    
        $client = new WebClient( //$client is a newly created web client formatted in JSON
          [
              'responseConfig' => [
                  'format' => WebClient::FORMAT_JSON
              ],
          ]
        );
        $response = $client->createRequest() //Method used to create new HTTP request
        ->setMethod('POST')
        ->setUrl(yiicfg::OCS . 'users')
        ->setData(['userid' => $username, 
                    'password' => $temppass, // Default to least permission 
                  ])
        ->setOptions(['timeout' => 5,])
        ->send();
        //Yii::error("\n" . "OCS_SHARE was: ". yiicfg::OCS_SHARE . 'shares');
        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);
        Yii::error("\n" . "Vals is: ". json_encode($vals));
        if (! $vals[$index['STATUS'][0]]['value'] == "ok") {
          throw new UserException('Sorry couldn\'t create user on OwnCloud.');
        } 
        // Now continue with original method of adding user to Owncloud
        // This should overwrite the temporary password
        // Add Username and Password to OC
        User::changeUserPasswordOnOwncloud($username);
      }
    }

    public function shareOCFolderWithUser($username, $projectname) {
      
      $client = new WebClient( //$client is a newly created web client formatted in JSON
        [
            'responseConfig' => [
                'format' => WebClient::FORMAT_JSON
            ],
        ]
      );
      //curl -X POST /shares -d path="/Projects/Land" -d shareType=1 -d shareWith="Land"

      $response = $client->createRequest() //Method used to create new HTTP request
        ->setMethod('POST')
        ->setUrl(yiicfg::OCS_SHARE . 'shares')
        ->setData(['path' => '/Projects/' . $projectname, 'shareType' => 0, 'shareWith' => $username,
                    'permissions' => 1, // Default to least permission 
                  ])
        ->setOptions(['timeout' => 5,])
        ->send();
        Yii::error("\n" . "OCS_SHARE was: ". yiicfg::OCS_SHARE . 'shares');
        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);
        Yii::error("\n" . "Vals is: ". json_encode($vals));
        if ( $vals[$index['STATUS'][0]]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
        
    }

/*
    public function shareOCFolderWithUser($username, $projectname) {
      $client = new WebClient(
        [
            'responseConfig' => [
                'format' => WebClient::FORMAT_JSON
            ],
        ]
      );
      //curl -X POST /shares -d path="/Projects/Land" -d shareType=1 -d shareWith="Land"

      $response = $client->createRequest()
        ->setMethod('post')
        ->setUrl(yiicfg::OCS_SHARE . 'shares')
        ->setData(['path' => '/Projects/' . $projectname, 'shareType' => 0, 'shareWith' => $username,
                    'permissions' => 1, // Default to least permission 
                  ])
        ->setOptions(['timeout' => 5,])
        ->send();
        Yii::error("\n" . "OCS_SHARE was: ". yiicfg::OCS_SHARE . 'shares');
        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);
        Yii::error("\n" . "Vals is: ". json_encode($vals));
        if ( $vals[$index['STATUS'][0]]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
}*/

  

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
