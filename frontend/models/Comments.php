<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $id_post
 * @property string $comment
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_post', 'comment'], 'required'],
            [['id', 'id_post', 'id_commentator'], 'integer'],
            [['comment'], 'string'],
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
            'id_commentator' => 'ID Commentator',
            'id_post' => 'Id Post',
            'comment' => 'Comment',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_commentator']);
    }
}
