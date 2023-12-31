<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2018/4/26 0026 16:26
 *  for: 短信抽象类
 *  各种短信服务商的接口开发都要实现此抽象类
 */

namespace sms\template\service;


use think\facade\Config;

abstract class TemplateInterface
{

    /**
     * 默认配置
     * @var array
     */
    protected $config = [
        'account' => '',                    //  短信账号
        'password'=> '',                     //  短信账号密码
        'signature' => '',
        'app_id' => ''
    ];

    private $error;  //错误信息

    /**
     * 设置配置
     * @param $config
     */
    public function setConfig($config){
        $this->config = $config;
    }


    /**
     * 使用 $this->name 获取配置
     * @param  string $name 配置名称
     * @return multitype    配置值
     */
    public function __get($name) {
        return $this->config[$name];
    }

    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    public function __isset($name){
        return isset($this->config[$name]);
    }

    /**
     * 获取短信异常信息
     * @return mixed
     */
     public function getError(){
       return $this->error;
     }

    /**
     * 设置短信异常信息
     * @param $message
     */
     public function setError($message){
         $this->error = $message;
     }

    /**
     * 发送短信
     * @param $phone
     * @param string $code 短信模板Code
     * @param array $param  ["code" => "12345","product" => "ddd"];
     * @return mixed
     */
    abstract public function sendSms($phone,$code,$param);


    /**
     * 查询发送短信内容
     * @param $phone
     * @return mixed
     */
    abstract public function querySend($phone);

    /**
     * 获取短信请求地址
     * @param $api
     * @return mixed
     */
    abstract public function getRequestUrl($api);

}