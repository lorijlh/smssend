<?php
/**
 * Created by dailinlin.
 * Date: 2017/9/26 9:56
 * for: 管理员管理
 */

namespace app\admin\controller;



use app\common\controller\BaseAdmin;
use think\facade\Config;
use think\Db;
use pay\PayManage;
use think\exception\HttpException;

class Business extends BaseAdmin
{

    /**
     * 充值管理
     */
    public function recharge(){
        if (request()->isAjax()){
            $list = $this->search('recharge_view');
            return $list;
        }else{
            return $this->fetch();
        }
    }
    
    /**
     * 充值审核
     */ 
    public function audit(){
        $data = request()->post();
        $message = $data['status']==1?'到账通过':'未到账';
        $result = false;
        if($data['status']==1){
            $recharge = Db::name('recharge')->where('id',$data['id'])->where('state',0)->find();
            if ($recharge){
                $result = Db::name('recharge')->where('id',$data['id'])->update(['state'=>1]);

                //通知之后的业务操作
                PayManage::notifyOperation($recharge);
            }
        }else{
            $result = Db::name('recharge')->where('id',$data['id'])->update(['state'=>2]);
        }
        if($result){
            return ['status'=>true,'message'=>$message.'成功!'];
        }else{
            return ['status'=>false,'message'=>$message.'失败!'];
        }
    }
    
    
    /**
     * 删除充值记录
     */
    public function remove(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result = Db::name('recharge')->delete($ids);
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            throw new HttpException(502,'请求不合法');
        }
    }
    
     /**
     * 用户管理
     */
    public function member(){
        if (request()->isAjax()){
            $list = $this->search('admin_view');
            return $list;
        }else{
            return $this->fetch();
        }
    }
    
     /**
     * 财务管理
     */
    public function account(){
         if (request()->isAjax()){
            $list = $this->search('account_view');
            return $list;
        }else{
            return $this->fetch();
        }
    }
    
    /**
     * 后台上分资金管理
     */ 
    public function capital(){
        $uid = request()->post('id');
        $capital = request()->post('capital');
        PayManage::adminCapital($uid,$capital);
        return ['status'=>true,'message'=>$capital>0?'后台充值成功':'后台减款成功'];
    }
    
     /**
     * 发送记录
     */
    public function log(){
        if (request()->isAjax()){
            $list = $this->search('send_log_view');
            return $list;
        }else{
            return $this->fetch();
        }
    }
    
     /**
     * 管理员帮忙购买短信
     */
    public function sms_num(){
        $uid = request()->post('id');
        $num = request()->post('num');
        //获取账号余额
        $balance = Db::name('admin')->where('id',$uid)->value('balance');
        $price = Config::get('sms.price');
        $pay = $num*$price;
        if ($num>0) {
           if($balance<$pay){
               return ['status'=>false,'message'=>'账号余额不足，无法加短信!'];
           }
           PayManage::adminSms($uid,$num,$balance);
           return ['status'=>true,'message'=>"后台购买短信{$num}条"];
        }else{
            //减少用户短信数量
            Db::name('admin')->where('id',$uid)->setInc('num',$num);
            return ['status'=>true,'message'=>"短信条数减少{$num}条!"];
        }
       
    }
}