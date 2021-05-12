<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "follower".
 *
 * @property int $id
 * @property int $id_account
 * @property int $id_follower
 */
class Follower extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'follower';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_account', 'id_follower'], 'required'],
            [['id', 'id_account', 'id_follower'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_account' => 'Id Account',
            'id_follower' => 'Id Follower',
        ];
    }
}
