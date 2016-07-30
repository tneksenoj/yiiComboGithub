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
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Contributions[] $contributions
 * @property Sitedata[] $ds
 * @property Credentials[] $credentials
 * @property Projects[] $ps
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContributions()
    {
        return $this->hasMany(Contributions::className(), ['UID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDs()
    {
        return $this->hasMany(Sitedata::className(), ['DID' => 'DID'])->viaTable('contributions', ['UID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credentials::className(), ['UID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPs()
    {
        return $this->hasMany(Projects::className(), ['PID' => 'PID'])->viaTable('credentials', ['UID' => 'id']);
    }

    public function getOcUsers()
    {
        return $this->hasOne(OcUsers::className(), ['uid' => 'username']);
    }

    public static function deleteOwncloudUser($username)
    {

      $client = new WebClient([
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]);

      $response = $client->createRequest()
        ->setMethod('delete')
        ->setUrl(yiicfg::OCS. '/users/' . $username )
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

    public static function getOwncloudShares($username)
    {

      $client = new WebClient([
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]);

      $response = $client->createRequest()
        ->setMethod('get')
        ->setUrl(yiicfg::OCS. '/users/' . $username .  '/groups')
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[2]['value'] == "ok" && array_key_exists("ELEMENT", $index) > 0 ) {
          $groups = array_map( function($el) use ($vals) { return $vals[$el]["value"]; }, $index["ELEMENT"] );
          return $groups;
        } else {
          return [];
        }
    }


    public static function changeUserPasswordOnOwncloud($username)
    {
        // Get Information about user from Yiicombo
        //$user = User::find()->where(['username' => $username])->one();
        $user = User::findOne(['username' => $username]);
        $ocuser = OcUsers::findOne(['uid' => $user->username]);

        if( $user && $ocuser ) {
          $ocuser->password = '1|'. $user->password_hash;
          if(!$ocuser->save())
          {
              throw new UserException('Sorry there was an error accessing the user on OwnCloud.');
          }
        }
        return;
    }
}
