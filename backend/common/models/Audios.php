<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "audios".
 *
 * @property int $id
 * @property string $name
 */
class Audios extends \yii\db\ActiveRecord
{
    // Fayl upload uchun vaqtinchalik property
    public $audioFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],

            // audioFile uchun qoida
            [['audioFile'], 'file', 'skipOnEmpty' => false, 'extensions' => ['mp3', 'wav', 'm4a']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'audioFile' => 'Audio File',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AudiosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AudiosQuery(get_called_class());
    }
}
