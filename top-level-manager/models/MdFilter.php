<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "md_filter".
 *
 * @property integer $id
 * @property string $attribute
 * @property string $value
 * @property string $operator
 * @property string $last_updated
 * @property integer $id_script
 * @property string $identifier
 *
 * @property Script $idScript
 */
class MdFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'md_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_updated'], 'safe'],
            [['id_script', 'identifier'], 'required'],
            [['id_script'], 'integer'],
            [['attribute', 'value', 'operator'], 'string', 'max' => 45],
            [['identifier'], 'string', 'max' => 32],
            [['identifier'], 'unique'],
            [['id_script'], 'exist', 'skipOnError' => true, 'targetClass' => Script::className(), 'targetAttribute' => ['id_script' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute' => 'Attribute',
            'value' => 'Value',
            'operator' => 'Operator',
            'last_updated' => 'Last Updated',
            'id_script' => 'Id Script',
            'identifier' => 'Identifier',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdScript()
    {
        return $this->hasOne(Script::className(), ['id' => 'id_script']);
    }
}
