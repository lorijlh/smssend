<?php
/**
 * Created by pengxingyuan.
 * Date: 2018/8/8
 * Time: 16:24
 */

namespace app\common\validate;




class Service extends BaseValidate
{
    protected $rule =   [
        'name'   =>'require',
        'class_name'   => 'require|alphaDash',
        'account'   =>'require',
        'password'   => 'require',
        //'signature'   =>'require',
    ];

    //字段信息
    protected $field = [
        'name'      => '短信服务商',
        'class_name'         => '接口名称',
        'account'     => '短信account',
        'password'        => '短信key',
    ];

}