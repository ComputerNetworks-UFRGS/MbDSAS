<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mlm".
 *
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property string $ip
 * @property string $mac
 *
 * @property Md[] $mds
 * @property MlmLanguage[] $mlmLanguages
 * @property Language[] $idLanguages
 * @property MlmScript[] $mlmScripts
 * @property Script[] $scripts
 */
class Mlm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mlm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'url'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 15],
            [['mac'], 'string', 'max' => 20],
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
            'ip' => 'Ip',
            'mac' => 'Mac',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMds()
    {
        return $this->hasMany(Md::className(), ['mlm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMlmLanguages()
    {
        return $this->hasMany(MlmLanguage::className(), ['id_mlm' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLanguages()
    {
        return $this->hasMany(Language::className(), ['id' => 'id_language'])->viaTable('mlm_language', ['id_mlm' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMlmScripts()
    {
        return $this->hasMany(MlmScript::className(), ['mlm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScripts()
    {
        return $this->hasMany(Script::className(), ['id' => 'script_id'])->viaTable('mlm_script', ['mlm_id' => 'id']);
    }
}
