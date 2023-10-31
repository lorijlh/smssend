<?php


namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\facade\Config;
use pay\BudPay;
use pay\PayManage;
use think\Db;

class Pay extends BaseAdmin
{

    /**
     *充值页面 
     */
    public function topay(){
        $goods_id = request()->get('goods_id');
        $type = request()->get('type');
        if($type=='usdt'){
            $price = Db::name('goods')->where('id',$goods_id)->value('usdt');
        }else{
            $price = Db::name('goods')->where('id',$goods_id)->value('price');
        }
        $this->assign('price', $price);
        $this->assign('config', Config::get($type.'.'));
        $this->assign('goods_id', $goods_id);
        return $this->fetch($type);
    }

    /**
     * 去充值
     */
    public function recharge(){
        //未登录跳转登录
        if (!$this->uid){
            $this->redirect(url('index/login'));
        }

        //充值操作
        $goods_id = request()->param('goods_id');
        $goods = Db::name('goods')->find($goods_id);
        $type = request()->param('type');
        if (in_array($type,['usdt','bank','alipay'])) {
            PayManage::offlineToPay($this->uid,$goods,$type);
            return ['status'=>true,'message'=>'支付成功，请等待审核'];
        }else{
            PayManage::toPay($this->uid,$goods,$type);
        }
    }

   //**************************阿里支付回调start***************************//
    /**
     * 阿里支付回调通知
     */
    public function alipay_back(){
        request()->domain();
    }

    /**
     * 阿里支付同步通知
     */
    public function alipay_return(){
        $config = config('alipay.');
        $pay = new Pay($config);
        $data = request()->param();
        if ($pay->driver('alipay')->gateway()->verify($data)) {
            $out_trade_no = $data['out_trade_no'];
            $recharge = Db::name('recharge')->where('out_trade_no',$out_trade_no)->where('state',0)->find();
            if ($recharge){
                Db::name('recharge')->where('out_trade_no',$out_trade_no)->update(['state'=>1]);

                //通知之后的业务操作
                PayManage::notifyOperation($recharge);
            }
            echo "success";
        }else{
            echo "fail";
        }
    }
    //**************************阿里支付回调end***************************//


    //**************************微信支付回调start***************************//
    /**
     * 微信支付回调通知
     */
    public function wechat_back(){
        $config = config('wechat.');
        $pay = new Pay($config);
        $data  = file_get_contents('php://input');
        $verify =  $pay->driver('wechat')->gateway('scan')->verify($data);
        if ($verify) {
            $out_trade_no = $verify['out_trade_no'];
            $recharge = Db::name('recharge')->where('out_trade_no',$out_trade_no)->where('state',0)->find();
            if ($recharge){
                Db::name('recharge')->where('out_trade_no',$out_trade_no)->update(['state'=>1]);

                //通知之后的业务操作
                PayManage::notifyOperation($recharge);
            }
            echo "success";
        } else {
            echo "fail";
        }
    }
    //**************************微信支付回调end***************************//



    //**************************片刻云支付回调start***************************//
    /**
     * 片刻云支付回调通知
     */
    public function pkypay_back(){
        $config = config('pkypay.');
        if (BudPay::verify($config)){
            $out_trade_no = $_GET['payId'];
            $recharge = Db::name('recharge')->where('out_trade_no',$out_trade_no)->where('state',0)->find();
            if ($recharge){
                Db::name('recharge')->where('out_trade_no',$out_trade_no)->update(['state'=>1]);

                //通知之后的业务操作
                PayManage::notifyOperation($recharge);
            }
            echo "success";
        }else{
            echo "error_sign";//sign校验不通过
        }
    }

    /**
     * 阿里支付同步通知
     */
    public function pkypay_return(){

    }
    //**************************片刻云支付回调end***************************//
}