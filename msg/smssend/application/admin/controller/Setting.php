<?php
/**
 * Created by dh2y.
 * Date: 2018/11/28 16:55
 * for:
 */
 //

namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\facade\Config;
use think\facade\Env;

class Setting extends  BaseAdmin
{

   public function index(){
        if(request()->isAjax()){
            $model['base'] = Config::get('base.');
            $model['relation'] = Config::get('relation.');
            $model['redis'] = Config::get('redis.');
            $model['sms'] = Config::get('sms.');
            return $model;
        }else{
            return $this->fetch();
        }
   }

    /**
     * 网站基础配置
     * @return array
     */
    public function base(){
        $base = request()->post();
        $extra = Env::get('config_path').'base.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($base, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);
            $config = str_replace('\'true\'','true',$config);
            $config = str_replace('\'false\'','false',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'网站基础配置设置成功'];
        }else{
            return ['status'=>false,'message'=>'网站基础配置设置失败'];
        }
    }


    /**
     * 网站联系配置
     * @return array
     */
   public function relation(){
       $qiniu = request()->post();
       $extra = Env::get('config_path').'relation.php';
       if(false!==fopen($extra,'w+')){
           $config = var_export($qiniu, true);
           $config = str_replace('\'true\'','true',$config);
           $config = str_replace('\'false\'','false',$config);

           file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
           return ['status'=>true,'message'=>'网站联系设置成功'];
       }else{
           return ['status'=>false,'message'=>'网站联系设置失败'];
       }
   }

    /**
     * redis配置
     * @return array
     */
    public function redis(){
        $redis = request()->post();
        $extra = Env::get('config_path').'admin/redis.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($redis, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'redis参数设置成功'];
        }else{
            return ['status'=>false,'message'=>'redis参数设置失败'];
        }
    }

    /**
     * 支付设置
     * @return mixed
     */
    public function pay(){
        if(request()->isAjax()){
            $model['alipay'] = Config::get('alipay.');
            $model['bank'] = Config::get('bank.');
            $model['usdt'] = Config::get('usdt.');
            $model['zfb'] = Config::get('zfb.');
            $model['wechat'] = Config::get('wechat.');
            return $model;
        }else{
            return $this->fetch();
        }
    }

    /**
     * 支付宝支付
     * @return array
     */
    public function alipay(){
        $pay = request()->post();
        $extra = Env::get('config_path').'alipay.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($pay, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);
            $config = str_replace('\'true\'','true',$config);
            $config = str_replace('\'false\'','false',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'支付宝支付设置成功'];
        }else{
            return ['status'=>false,'message'=>'支付宝支付设置失败'];
        }
    }

    /**
     * 银行卡支付
     * @return array
     */
    public function bank(){
        $pay = request()->post();
        $extra = Env::get('config_path').'bank.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($pay, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);
            $config = str_replace('\'true\'','true',$config);
            $config = str_replace('\'false\'','false',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'银行卡支付设置成功'];
        }else{
            return ['status'=>false,'message'=>'银行卡支付设置失败'];
        }
    }

    /**
     * USDT支付
     * @return array
     */
    public function usdt(){
        $pay = request()->post();
        $extra = Env::get('config_path').'usdt.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($pay, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);
            $config = str_replace('\'true\'','true',$config);
            $config = str_replace('\'false\'','false',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'USDT支付设置成功'];
        }else{
            return ['status'=>false,'message'=>'USDT支付设置失败'];
        }
    }

    /**
     * 支付宝官方支付
     * @return array
     */
    public function zfb(){
        $pay = request()->post();
        $extra = Env::get('config_path').'zfb.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($pay, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);
            $config = str_replace('\'true\'','true',$config);
            $config = str_replace('\'false\'','false',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'支付宝支付设置成功'];
        }else{
            return ['status'=>false,'message'=>'支付宝支付设置失败'];
        }
    }

    /**
     * 微信官方支付
     * @return array
     */
    public function wechat(){
        $pay = request()->post();
        $extra = Env::get('config_path').'wechat.php';
        if(false!==fopen($extra,'w+')){
            $config = var_export($pay, true);
            $config = str_replace('array (','[',$config);
            $config = str_replace(')',']',$config);
            $config = str_replace('\'true\'','true',$config);
            $config = str_replace('\'false\'','false',$config);

            file_put_contents($extra, "<?php\t\r\t\r return " . $config . ";");
            return ['status'=>true,'message'=>'微信支付设置成功'];
        }else{
            return ['status'=>false,'message'=>'微信支付设置失败'];
        }
    }
}