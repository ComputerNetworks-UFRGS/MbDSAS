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
 *
 * @property MdFilter[] $mdFilters
 * @property MlmScript[] $mlmScripts
 * @property Mlm[] $mlms
 * @property Language $idLanguage
 * @property ScriptRepository[] $scriptRepositories
 * @property Repository[] $repositories
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
            [['id_language'], 'required'],
            [['id_language'], 'integer'],
            [['owner', 'name', 'row_status'], 'string', 'max' => 100],
            [['source', 'storage_type'], 'string', 'max' => 255],
            [['admin_status', 'oper_status'], 'string', 'max' => 45],
            [['error'], 'string', 'max' => 150],
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
        ];
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
    public function getMlmScripts()
    {
        return $this->hasMany(MlmScript::className(), ['script_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMlms()
    {
        return $this->hasMany(Mlm::className(), ['id' => 'mlm_id'])->viaTable('mlm_script', ['script_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'id_language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScriptRepositories()
    {
        return $this->hasMany(ScriptRepository::className(), ['script_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositories()
    {
        return $this->hasMany(Repository::className(), ['id' => 'repository_id'])->viaTable('script_repository', ['script_id' => 'id']);
    }
}
