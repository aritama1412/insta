<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_post
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_post'], 'required'],
            [['id_user', 'id_post'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_post' => 'Id Post',
        ];
    }
}
