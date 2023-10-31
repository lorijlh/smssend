<?php

namespace pay;

class BudPay
{
    public static $alipay = 2;
    public static $wechat = 1;

    public static $baseUrl = 'http://pay.sanface.cn/';

    public static $config = [
        'mid' => '1099',
        'token' => 'g9ukw35pd2bi1g8s1l13ov3381yy',
        'notifyUrl' => '',
        'returnUrl' => '',
    ];


    /**
     * 跳转到支付
     * @param $data  array ['out_trade_no'=>'订单号','param'=>'可选扩展参数，不填传空值','price'=>'金额']
     * @param $type int 微信支付传入1 支付宝支付传入2
     * @param array $config
     */
    public static function toPay($data,$type,$config=[]){
        if (count($config)>0){
            self::$config = array_merge(self::$config,$config);
        }
        $param['mid'] = self::$config['mid'];
        $param['payId'] = $data['out_trade_no'];
        $param['param'] = $data['param'];
        $param['type'] = $type;
        $param['price'] = $data['price'];
        $param['sign'] = md5(implode('',$param).self::$config['token']);
        $param['notifyUrl'] = self::$config['notifyUrl'];
        $param['returnUrl'] = self::$config['returnUrl'];
        $param['isHtml'] = 1;
        $location =  self::$baseUrl.'createOrder?'.http_build_query($param);
        header('location:'.$location);
    }

    /**
     * 回调验证
     * @param array $config
     * @return bool
     */
    public static function verify($config=[]){
        if (count($config)>0){
            self::$config = array_merge(self::$config,$config);
        }
        $mid = $_GET['mid'];//商户ID
        $payId = $_GET['payId'];//商户订单号
        $param = $_GET['param'];//创建订单的时候传入的参数
        $type = $_GET['type'];//支付方式 ：微信支付为1 支付宝支付为2
        $price = $_GET['price'];//订单金额
        $reallyPrice = $_GET['reallyPrice'];//实际支付金额
        $sign = $_GET['sign'];//校验签名，计算方式 = md5(mid+payId + param + type + price + reallyPrice + 通讯密钥)
        $_sign =  md5($mid.$payId . $param . $type . $price . $reallyPrice . self::$config['token']);
        if ($_sign != $sign) {
            return false;
        }else{
            return true;
        }
    }
}