<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "md".
 *
 * @property integer $id
 * @property string $chassis_id_subtype
 * @property string $chassis_id
 * @property string $port_id
 * @property string $port_id_subtype
 * @property string $port_desc
 * @property string $sys_name
 * @property string $sys_desc
 * @property string $sys_cap_supported
 * @property string $sys_cap_enabled
 * @property string $man_addr_entry
 * @property string $connect_time
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
            [['port_desc', 'sys_desc'], 'string'],
            [['connect_time'], 'safe'],
            [['chassis_id_subtype', 'port_id_subtype'], 'string', 'max' => 50],
            [['chassis_id'], 'string', 'max' => 60],
            [['port_id', 'man_addr_entry'], 'string', 'max' => 45],
            [['sys_name'], 'string', 'max' => 100],
            [['sys_cap_supported', 'sys_cap_enabled'], 'string', 'max' => 80],
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
            'port_id' => 'Port ID',
            'port_id_subtype' => 'Port Id Subtype',
            'port_desc' => 'Port Desc',
            'sys_name' => 'Sys Name',
            'sys_desc' => 'Sys Desc',
            'sys_cap_supported' => 'Sys Cap Supported',
            'sys_cap_enabled' => 'Sys Cap Enabled',
            'man_addr_entry' => 'Man Addr Entry',
            'connect_time' => 'Connect Time',
        ];
    }
}
