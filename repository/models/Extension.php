<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "extension".
 *
 * @property integer $id
 * @property string $extension
 * @property string $version
 * @property string $vendor
 * @property string $revision
 * @property string $descr
 * @property string $last_updated
 * @property integer $id_language
 *
 * @property Language $idLanguage
 */
class Extension extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extension';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extension', 'id_language'], 'required'],
            [['descr'], 'string'],
            [['last_updated'], 'safe'],
            [['id_language'], 'integer'],
            [['extension', 'version', 'vendor', 'revision'], 'string', 'max' => 45],
            [['extension'], 'unique'],
            [['id_language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['id_language' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'extension' => 'Extension',
            'version' => 'Version',
            'vendor' => 'Vendor',
            'revision' => 'Revision',
            'descr' => 'Descr',
            'last_updated' => 'Last Updated',
            'id_language' => 'Id Language',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'id_language']);
    }
}
