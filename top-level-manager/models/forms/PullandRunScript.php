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
class PullandRunScript extends Model
{
    public $url; 
    public $arguments = "";
    public $language = "Java";
    public $storage = "Volatile";
    public $block = true;
    public $mlm = "192.168.1.2";

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['url'], 'required'],
        ];
    }

    public function getMlm(){
        return $this->mlm;
    }
}
