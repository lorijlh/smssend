<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/22 23:41
 * for:
 */


namespace app\mobile\validate;


use sms\Sms;
use think\Validate;

class Member extends Validate
{
    protected $rule = [
        'phone' => 'require|length:11',
        'password' => 'require|min:5|max:16',
        'code' => 'require|length:6|checkSms'
    ];


    protected $field = [
        'phone' => '手机号',
        'password' => '密码',
    ];

    protected $message = [
        'phone.length' => '请输入合法的手机号',
        'code.require' => '短信验证码不能为空',
    ];

    protected $scene = [
       'register'  => 'phone,password,code',
	   'login'  => 'phone,password',
    ];

    //短信验证码-验证
    public function checkSms($value, $rule='', $data='',$field=''){

        $ret = Sms::getInstance()->verifySmsCode($data['phone'],$value);
        if($ret){
            return $ret;
        }else{
            return Sms::getInstance()->getError();
        }
    }
}