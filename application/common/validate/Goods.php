<?php


namespace app\common\validate;


class Goods extends BaseValidate
{
    protected $rule = [
        'title' => 'require|max:200',
        'day' => 'require',
        'price' => 'require'
    ];

    protected $message = [
        'title.require' => '标题必须',
        'title.max' => '标题过长',
        'day.require' => 'vip天数',
        'give.require' => '作者必须',
        'content.require' => '内容必须'
    ];
}