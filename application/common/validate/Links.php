<?php


namespace app\common\validate;


class Links extends BaseValidate
{
    protected $rule =   [
        'name'   =>'require',
        'links'   =>'require|url',
    ];

    //字段信息
    protected $field = [
        'name'      => '友情网站名称',
        'links'   =>'链接',
    ];
}