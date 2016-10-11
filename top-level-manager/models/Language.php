<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $name
 * @property string $vendor
 * @property string $revision
 * @property string $descr
 * @property string $last_updated
 *
 * @property Extension[] $extensions
 * @property MlmLanguage[] $mlmLanguages
 * @property Mlm[] $idMlms
 * @property Script[] $scripts
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descr'], 'string'],
            [['last_updated'], 'safe'],
            [['name', 'vendor', 'revision'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'vendor' => 'Vendor',
            'revision' => 'Revision',
            'descr' => 'Descr',
            'last_updated' => 'Last Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtensions()
    {
        return $this->hasMany(Extension::className(), ['id_language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMlmLanguages()
    {
        return $this->hasMany(MlmLanguage::className(), ['id_language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMlms()
    {
        return $this->hasMany(Mlm::className(), ['id' => 'id_mlm'])->viaTable('mlm_language', ['id_language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScripts()
    {
        return $this->hasMany(Script::className(), ['id_language' => 'id']);
    }
}
