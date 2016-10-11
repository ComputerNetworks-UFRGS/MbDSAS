<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class BeginMbD extends Model
{
    public $owner;
    public $community;
    public $password;
    public $mbdsolution = "OSGi";
    public $mlm = "192.168.1.2";

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['owner', 'community', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],        
        ];
    }

    public function getMlm(){
        return $this->mlm;
    }
}
