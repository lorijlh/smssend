<?php


namespace app\common\model;


use think\Model;

class Config extends Model
{
    protected $pk='id';
    protected $autoWriteTimestamp = true;
    protected $json = ['value'];
    protected $jsonAssoc = true;
}