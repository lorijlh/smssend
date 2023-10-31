<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2018/4/26 0026 16:26
 * for: 短信SDK
 */

namespace sms\template;

use app\common\model\SendLog;

/** .-----------------------------使用说明---------------------------------
* $sms = new Sms();
* $sms->sendSms('17xx11076xx','你好，dh2y先生。我发给短信测试一下啦');//普通短信
 *
*
* $sms->sendSmsCode('17xx11076xx','register');                 //验证码短信
* $sms->verifySmsCode('17xx11076xx',587620);                   //验证短信的验证码
* echo $sms->getError();             //获取失败错误信息(验证，发送等错误信息)
* -------------------------------------------------------------------*/

class Sms
{
    /**
     * 操作句柄
     * @var string
     * @access protected
     */
    protected $handler    ;

    protected $config = [];

    protected $message;

    private static $instance=null;  //创建静态单列对象变量

    protected $template;
    
    protected $is_test = false;

    /**
     * SmsTemplate constructor.
     * @param array $model
     * @throws \Exception
     */
    private function __construct($model){
        /* 获取配置 */
        $class = '\\sms\\template\\service\\'. ucfirst($model);
        if(class_exists($class)){
            $this->handler  =   new $class();
        }else{
            // 类没有定义
            throw new \Exception('没有这个短信服务商');
        }
    }

    /**
     * 单列模式
     * @param array $class
     * @return Sms|null
     */
    public static function getInstance($class){
        if(empty(self::$instance)) {
            self::$instance=new Sms($class);
        }
        return self::$instance;
    }

    /**
     * 克隆函数私有化，防止外部克隆对象
     * @throws \Exception
     */
    private function __clone(){
        throw new \Exception('禁止克隆');
    }

    /**
     * 返还错误信息
     * @return string
     */
    public function getError(){
        return $this->handler->getError();
    }

    /**
     * 设置错误信息
     * @param $error
     */
    public function setError($error){
        $this->handler->setError($error);
    }

    /**
     * 获取发送的短信消息内容
     * @return mixed
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     *  设置配置
     * @param $service array 服务商
     * @param $template array 模板
     */
    public function setConfig($service,$template){
        $this->is_test = $service['is_test']==1?true:false;
        $this->handler->account = $service['account'];
        $this->handler->password = $service['password'];
        $this->handler->signature = $service['signature'];
        $this->handler->app_id = $service['app_id'];
        $this->template = $template;
        return $this;
    }

    /**
     * 发送短信
     * @param $phone
     * @param $is_temp
     * @return bool
     */
    public function sendSms($phone,$uid,$is_temp=0){
        $param = json_decode($this->template['params'],true);
        if(!empty($param) && is_array($param)){
            $one = [];$two = [];
            foreach ($param as $key=>$value){
                $one[] = '%'.$key.'%';
                $two[] = $value;
            }
            $message = str_replace($one, $two,$this->template['message']);
            $message = '【'.$this->template['signature'].'】'.$message;
            $this->message = $message;
        }else{
            $this->message = $this->template['message'];
        }
        $log = new SendLog();
        $log_id = $log->saveLog($uid,$phone,$this->message);
        
        //是否是测试发送
        if($this->is_test){
            $log->sendSucceed($log_id,$is_temp);
            return true;
        }
        
        if($this->handler->sendSms($phone, $this->template['code'],$param)){
            $log->sendSucceed($log_id,$is_temp);
            return true;
        }else{
            $log->sendFail($log_id,$this->handler->getError(),$is_temp);
            $this->setError($this->handler->getError());
            return false;
        }
    }



    public function __call($method,$args){
        //调用缓存类型自己的方法
        if(method_exists($this->handler, $method)){
            return call_user_func_array(array($this->handler,$method), $args);
        }else{
            // 类没有定义
            throw new \Exception('没有这个短信服务商驱动方法:'.$method);
        }
    }
}