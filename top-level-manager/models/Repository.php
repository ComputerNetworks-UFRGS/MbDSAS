<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repository".
 *
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property string $last_access
 *
 * @property ScriptRepository[] $scriptRepositories
 * @property Script[] $scripts
 */
class Repository extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repository';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_access'], 'safe'],
            [['label', 'url'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'url' => 'Url',
            'last_access' => 'Last Access',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScriptRepositories()
    {
        return $this->hasMany(ScriptRepository::className(), ['repository_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScripts()
    {
        return $this->hasMany(Script::className(), ['id' => 'script_id'])->viaTable('script_repository', ['repository_id' => 'id']);
    }
}
