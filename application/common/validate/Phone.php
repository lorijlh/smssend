<?php
/**
 * Created by pengxingyuan.
 * Date: 2018/8/8
 * Time: 16:24
 */

namespace app\common\validate;




class Phone extends BaseValidate
{
    protected $rule =   [
        'phone'   =>'require|unique:phone',
    ];

    //字段信息
    protected $field = [
        'phone'      => '手机号',
    ];

}