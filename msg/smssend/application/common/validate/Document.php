<?php


namespace app\common\validate;


class Document extends BaseValidate
{
    protected $rule = [
        'title' => 'require|max:50',
        'des' => 'require',
        'thumb_img' => 'require',
        'content' => 'require'
    ];

    protected $message = [
        'title.require' => '标题必须',
        'title.max' => '标题过长',
        'thumb_img.require' => '请上传缩略图',
        'des.require' => '作者必须',
        'content.require' => '内容必须'
    ];
}