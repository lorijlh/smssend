<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/24 10:32
 * for:
 */


namespace app\common\validate;


use think\Db;

class Template extends BaseValidate
{
    protected $rule = [
        'code'      => 'require',
        'message'   => 'require',
        'sid'       => 'require|checkSid',
    ];

    //字段信息
    protected $field = [
        'code'      => '模板ID',
        'message'   => '模板内容',
        'sid'       => '短信服务商'
    ];

    protected $message = [
         'sid.checkSid' => '请选择短信服务商'
    ];


    //短信验证码-验证
    public function checkSid($value, $rule='', $data='',$field=''){

        $ret = Db::name('service')->where('id',$value)->find();
        return $ret?true:false;
    }
}