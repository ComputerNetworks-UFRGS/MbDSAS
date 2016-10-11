<?php

namespace app\models\forms\repository;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Repositorycreate extends Model
{
    public $label;
    public $address;

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
