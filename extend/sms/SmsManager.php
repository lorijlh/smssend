<?php
namespace sms;

use think\facade\Config;

/**
 * Class SmsManager
 * @package sms
 */
class SmsManager
{
    /**
     * 返回相应的短信单列
     * @return template\Sms|text\Sms|null
     */
    public static function getInstance($class)
    {
        $service = Config::get('service.');
        switch ($service[$class]['type']){
            case 'text':
                $sms = \sms\text\Sms::getInstance($class);
                break;
            case 'template':
                $sms = \sms\template\Sms::getInstance($class);
                break;
            default:
                $sms = \sms\text\Sms::getInstance($class);
                break;
        }
        return  $sms;
    }
}