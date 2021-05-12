<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $content
 * @property int|null $id_user
 * @property string|null $likes
 * @property string|null $comments
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['id_user'], 'integer'],
            [['likes', 'comments'], 'string', 'max' => 45],
            [['img'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'img' => 'Gambar',
            'id_user' => 'Id User',
            'likes' => 'Likes',
            'comments' => 'Comments',
        ];
    }

    public function getSomething()
    {
        // return $this->hasOne(Pemesanan::className(), ['id' => 'id_pemesanan']);
        $pemesanan = Pemesanan::getPemesanan();
        return $pemesanan->customer->nama;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
