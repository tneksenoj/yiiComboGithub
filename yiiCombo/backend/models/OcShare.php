<?php

namespace backend\models;

use Yii;


/**
 * This is the model class for table "oc_share".
 *
 * @property integer $id
 * @property integer $share_type
 * @property string $share_with
 * @property string $uid_owner
 * @property string $uid_initiator
 * @property integer $parent
 * @property string $item_type
 * @property string $item_source
 * @property string $item_target
 * @property integer $file_source
 * @property string $file_target
 * @property integer $permissions
 * @property integer $stime
 * @property integer $accepted
 * @property string $expiration
 * @property string $token
 * @property integer $mail_send
 */
class OcShare extends \yii\db\ActiveRecord
{
    public $permlist;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oc_share';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('ocdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['share_type', 'parent', 'file_source', 'permissions', 'stime', 'accepted', 'mail_send'], 'integer'],
            [['permlist'], 'each', 'rule' => ['integer'] ],
            [['expiration'], 'safe'],
            [['share_with', 'item_source', 'item_target'], 'string', 'max' => 255],
            [['uid_owner', 'uid_initiator', 'item_type'], 'string', 'max' => 64],
            [['file_target'], 'string', 'max' => 512],
            [['token'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_type' => 'Share Type',
            'share_with' => 'Share With',
            'uid_owner' => 'Uid Owner',
            'uid_initiator' => 'Uid Initiator',
            'parent' => 'Parent',
            'item_type' => 'Item Type',
            'item_source' => 'Item Source',
            'item_target' => 'Item Target',
            'file_source' => 'File Source',
            'file_target' => 'File Target',
            'permissions' => 'Permissions',
            'stime' => 'Stime',
            'accepted' => 'Accepted',
            'expiration' => 'Expiration',
            'token' => 'Token',
            'mail_send' => 'Mail Send',
        ];
    }

    /**
     * @inheritdoc
     * @return OcQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OcQuery(get_called_class());
    }
}
