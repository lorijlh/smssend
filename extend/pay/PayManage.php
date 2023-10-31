<?php


namespace pay;


use think\Db;
use Yansongda\Pay\Pay;
use think\facade\Config;

class PayManage
{
        
         /**
         * 线下去支付
         * @param $data
         * @param $type
         */
        public static function offlineToPay($uid,$data,$type){
            $param = self::makeOrder($uid,$data,$type);
            return $param;
        }


        /**
         * 去支付
         * @param $data
         * @param $type
         */
        public static function toPay($uid,$data,$type){
            $param = self::makeOrder($uid,$data,$type);
            switch ($type){
                //线上支付自动到账类
                case 'pkypay': self::pkypay($param);break;
                case 'alipay': self::alipay($param);break;
                case 'wechat': self::wechat($param);break;
                default: self::pkypay($param);break;
            }
        }

        /**
         * 支付宝支付
         * @param $data
         * @return mixed
         */
        public static function alipay($data){
            $config = config('alipay.');
            $config['notify_url'] =request()->domain().$config['notify_url'];
            $config['return_url'] =request()->domain().$config['return_url'];
            $config_biz = [
                'out_trade_no' =>$data['out_trade_no'],
                'total_amount' => $data['price'],
                'subject'      => '充值',
            ];
            $pay = new Pay($config);
            return $pay->driver('alipay')->gateway('web')->pay($config_biz);
        }

        /**
         * 微信支付
         * @param $data
         * @return mixed
         */
        public static function wechat($data){
            $config = config('wechat.');
            $config['notify_url'] =request()->domain().$config['notify_url'];
            $config_biz = [
                'out_trade_no' => $data['out_trade_no'],
                'total_fee' => $data['price']*100, // **单位：分**
                'body' => '充值',
                'spbill_create_ip' => request()->ip(),
            ];
            $pay = new Pay($config);
            return $pay->driver('wechat')->gateway('scan')->pay($config_biz);
        }

        /**
         * 片刻云支付
         * @param $data
         */
        public static function pkypay($data){
            $config = config('pkypay.');
            $config['notifyUrl'] =request()->domain().$config['notifyUrl'];
            $config['returnUrl'] =request()->domain().$config['returnUrl'];
            $params = ['out_trade_no'=>$data['out_trade_no'],'param'=>'','price'=>$data['price']];
            BudPay::toPay($params,2,$config);
        }


        /**
         * 通知业务操作
         * @param $recharge
         * @throws \think\Exception
         */
        public static function notifyOperation($recharge){
            //获取账号余额
            $balance = Db::name('admin')->where('id',$recharge['uid'])->value('balance');
            //增加资金记录
            $account['uid'] = $recharge['uid'];
            $account['money'] = $recharge['amount']+$recharge['give_amount'];
            $account['balance'] = $balance;
            $account['remark'] = '充值到账';
            $account['create_time'] = time();
            $account['update_time'] = time();
            Db::name('account')->insert($account);
            //增加用户资金
            Db::name('admin')->where('id',$recharge['uid'])->setInc('balance',$account['money']);

            //购买VIP增加资金记录
            $goods = json_decode($recharge['goods'],true);
            $account['uid'] = $recharge['uid'];
            $account['symbol'] = '-';
            $account['money'] = $goods['price'];
            $account['balance'] = $account['money'];
            $account['remark'] = '购买：'.$goods['title'];
            $account['create_time'] = time();
            $account['update_time'] = time();
            Db::name('account')->insert($account);
            //减少用户资金
            Db::name('admin')->where('id',$recharge['uid'])->setDec('balance',$account['money']);

            //vip时间增加
            $vip = Db::name('admin')->field('vip,vip_time')->where('id',$recharge['uid'])->find();
            if ($vip['vip']==1){
                $vip_time = ($goods['day']+$goods['give'])*24*60*60;
                //增加vip
                Db::name('admin')->where('id',$recharge['uid'])->setInc('vip_time',$vip_time);
            }else{
                $vip_time = time()+($goods['day']+$goods['give'])*24*60*60;
                //增加vip，晋升为vip
                Db::name('admin')->where('id',$recharge['uid'])->update(['vip'=>1,'vip_time'=>$vip_time]);
            }
            //增加购买的条数
            if($goods['num']>0){
                Db::name('admin')->where('id',$recharge['uid'])->setInc('num',$goods['num']);
            }
            
        }

        /**
         * 创建支付订单
         * @param $uid
         * @param $data
         * @param $type
         * @return array
         */
        public static function makeOrder($uid,$data,$type){
            $param['out_trade_no'] = \Util::makeOrder();
            $param['uid'] = $uid;
            $param['amount'] = $data['price'];
            $param['type'] = $type;
            $param['goods'] = json_encode($data);
            $param['create_time'] = time();
            $param['update_time'] = time();
            Db::name('recharge')->insert($param);
            return [
                'out_trade_no' =>  $param['out_trade_no'],
                'price' => $param['amount'],
                'title' => $data['title']
            ];
        }
        
        
         /**
         * 后台加减款
         * @param $uid
         * @param $capital
         */
        public static function adminCapital($uid,$capital){
            //获取账号余额
            $balance = Db::name('admin')->where('id',$uid)->value('balance');
            //增加资金记录
            $account['uid'] = $uid;
            $account['money'] = abs($capital);
            $account['symbol'] = $capital>0?'+':'-';
            $account['balance'] = $balance+$capital;
            $account['remark'] = $capital>0?'后台充值':'后台减款';
            $account['create_time'] = time();
            $account['update_time'] = time();
            Db::name('account')->insert($account);
            //增加用户资金
            Db::name('admin')->where('id',$uid)->setInc('balance',$capital);
        }
        
         /**
         * 后台购买短信
         * @param $uid
         * @param $num
         * @param $balance
         */
        public static function adminSms($uid,$num,$balance){
            //增加资金记录
            $price = Config::get('sms.price');
            $pay = $num*$price;
            $account['uid'] = $uid;
            $account['money'] = $pay;
            $account['symbol'] = '-';
            $account['balance'] = $balance-$pay;
            $account['remark'] ="后台购买短信{$num}条";
            $account['create_time'] = time();
            $account['update_time'] = time();
            Db::name('account')->insert($account);
            //增加用户短信数量
            Db::name('admin')->where('id',$uid)->setInc('num',$num);
            //减少用户资金
            Db::name('admin')->where('id',$uid)->setDec('balance',$pay);
        }

}