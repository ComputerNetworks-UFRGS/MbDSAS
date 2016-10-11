<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "script".
 *
 * @property integer $id
 * @property string $owner
 * @property string $name
 * @property string $source
 * @property string $admin_status
 * @property string $oper_status
 * @property string $storage_type
 * @property string $row_status
 * @property string $error
 * @property string $last_updated
 * @property string $descr
 * @property integer $id_language
 * @property string $code_identifier
 *
 * @property Code[] $codes
 * @property MdFilter[] $mdFilters
 * @property Language $idLanguage
 */
class Script extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'script';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_updated'], 'safe'],
            [['descr'], 'string'],
            [['id_language', 'code_identifier'], 'required'],
            [['id_language'], 'integer'],
            [['owner', 'name', 'row_status'], 'string', 'max' => 100],
            [['source', 'storage_type'], 'string', 'max' => 255],
            [['admin_status', 'oper_status'], 'string', 'max' => 45],
            [['error'], 'string', 'max' => 150],
            [['code_identifier'], 'string', 'max' => 32],
            [['code_identifier'], 'unique'],
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
            'owner' => 'Owner',
            'name' => 'Name',
            'source' => 'Source',
            'admin_status' => 'Admin Status',
            'oper_status' => 'Oper Status',
            'storage_type' => 'Storage Type',
            'row_status' => 'Row Status',
            'error' => 'Error',
            'last_updated' => 'Last Updated',
            'descr' => 'Descr',
            'id_language' => 'Id Language',
            'code_identifier' => 'Code Identifier',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodes()
    {
        return $this->hasMany(Code::className(), ['id_script' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdFilters()
    {
        return $this->hasMany(MdFilter::className(), ['id_script' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'id_language']);
    }

    public function upload($file)
    {
        $path = realpath(\Yii::getAlias("@webroot")."/../script/");

        if ($file->saveAs($path.'/'. $file->baseName.'.'.$file->extension)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteFile($path){
        $path = realpath(\Yii::getAlias("@webroot")."/../script/$path");
        
        return unlink($path);
    }
}
