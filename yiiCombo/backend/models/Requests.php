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

    public static function createOwncloudUser($username)
    {
      // Get Information about user from Yiicombo
      //$user = User::find()->where(['username' => $username])->one();
      $user = User::findOne(['username' => $username]);

      if( ! OcUsers::find()->where(['uid' => $user->username])->exists() )
      {
        // Add Username and Password to OC
        $ocuser = new OcUsers();
        $ocuser->uid = $user->username;
        $ocuser->password = '1|'. $user->password_hash;
        if(!$ocuser->save()) {
            throw new UserException('Sorry there was an error creating user on OwnCloud.');
        }
        // Add email-address to OC for password recovery
        $ocpref = new OcPreferences();
        $ocpref->userid = $user->username;
        $ocpref->appid = 'settigs';
        $ocpref->configkey = 'email';
        $ocpref->configvalue = $user->email;
        if(!$ocpref->save()) {
            throw new UserException('Sorry there was an error creating user on OwnCloud.');
        }
      }
    }

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
        ->setData(['path' => '/Projects/'.$projectname, 'shareType' => 1, 'shareWith' => $username,
                    'permissions' => 1, /* Default to least permission */ 
                  ])
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[$index['STATUS'][0]]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
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
