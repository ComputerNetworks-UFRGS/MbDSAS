<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property integer $id
 * @property string $path
 * @property string $row_status
 * @property integer $id_script
 *
 * @property Script $idScript
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'string'],
            [['id_script'], 'required'],
            [['id_script'], 'integer'],
            [['row_status'], 'string', 'max' => 100],
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
            'path' => 'Path',
            'row_status' => 'Row Status',
            'id_script' => 'Id Script',
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
