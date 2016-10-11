<?php

namespace app\models\forms\mlm;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Mlmcreate extends Model
{
    public $label;
    public $address;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['label', 'address'], 'required'],     
        ];
    }
}
