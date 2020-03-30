<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Manage extends Validate
{
    protected $rule =   [
        'username'  => 'require|max:25',
        'password' => 'require',
        'captcha'=>'require|captcha'
    ];


    protected $message  =   [
        'username.require' => '名称必须',
        'username.max'     => '名称最多不能超过25个字符',
        'password.require' => '密码必须填写',
        'captcha.require' => '验证码必须填写',
        'captcha.captcha' => '验证码不正确',
    ];
}
