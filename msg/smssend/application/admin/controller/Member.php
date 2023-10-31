<?php


namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\Db;

class Member extends BaseAdmin
{
    /**
     * 用户中心
     */
    public function index(){
        if (request()->isAjax()){
            $data['member'] =  Db::name('admin')->field('password,token,status',true)->where('id',$this->uid)->find();
            $data['goods'] = Db::name('goods')->where('state',1)->select();
            return ['status'=>true,'data'=>$data];
        }
        return $this->fetch();
    }

    /**
     * 充值记录
     */
    public function pay_log(){
        if (request()->isAjax()){
            $cond['uid'] = ['eq',$this->uid];
            $list = $this->search('recharge',true,$cond);
            return $list;
        }else{
            return $this->fetch();
        }
    }

    /**
     * 财务明细
     */
    public function account(){
        if (request()->isAjax()){
            $cond['uid'] = ['eq',$this->uid];
            $list = $this->search('account',true,$cond);
            return $list;
        }else{
            return $this->fetch();
        }
    }
}