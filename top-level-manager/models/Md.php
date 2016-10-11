<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "md".
 *
 * @property integer $id
 * @property string $chassis_id_subtype
 * @property string $chassis_id
 * @property string $port_id_subtype
 * @property string $port_desc
 * @property string $sys_name
 * @property string $sys_desc
 * @property string $sys_cap_supported
 * @property string $sys_cap_enabled
 * @property string $man_addr_entry
 * @property string $connect_time
 * @property integer $mlm_id
 *
 * @property Mlm $mlm
 */
class Md extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'md';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mlm_id'], 'required'],
            [['mlm_id'], 'integer'],
            [['chassis_id_subtype', 'chassis_id', 'port_id_subtype', 'port_desc', 'sys_name', 'sys_desc', 'sys_cap_supported', 'sys_cap_enabled', 'man_addr_entry', 'connect_time'], 'string', 'max' => 45],
            [['mlm_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mlm::className(), 'targetAttribute' => ['mlm_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chassis_id_subtype' => 'Chassis Id Subtype',
            'chassis_id' => 'Chassis ID',
            'port_id_subtype' => 'Port Id Subtype',
            'port_desc' => 'Port Desc',
            'sys_name' => 'Sys Name',
            'sys_desc' => 'Sys Desc',
            'sys_cap_supported' => 'Sys Cap Supported',
            'sys_cap_enabled' => 'Sys Cap Enabled',
            'man_addr_entry' => 'Man Addr Entry',
            'connect_time' => 'Connect Time',
            'mlm_id' => 'Mlm ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMlm()
    {
        return $this->hasOne(Mlm::className(), ['id' => 'mlm_id']);
    }
}
