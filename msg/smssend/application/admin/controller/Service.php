<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2019/3/5 10:16
 * For: 短信服务商控制器
 */

namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use sms\SmsManager;
use think\Db;
use think\exception\HttpException;
use think\facade\Config;
use think\facade\Env;


class Service extends BaseAdmin
{
    /**
     * 短信服务商列表
     */
    public function index(){
        if (request()->isAjax()){
             //如果是系统管理员就显示服务商
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            if($group_id==1){
                 $cond['uid'] = ['in',"0,{$this->uid}"];
            }else{
                 $cond['uid'] = ['eq',$this->uid];
            }
            $list = $this->search('service',true,$cond);
            return $list;
        }else{
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            $this->assign('group_id',$group_id);
            return $this->fetch();
        }
    }


    /**
     * 添加短信服务商
     */
    public function add(){
        if (request()->isAjax()){
            if(request()->isPost()){
                $data = request()->post();
                $data['uid'] =isset($data['uid'])?$data['uid']:$this->uid;
                $model = new \app\common\model\Service();
                if($model->insertService($data)){
                    return ['status'=>true,'message'=>'短信服务商添加成功'];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }else{
                $data['service']= Config::get('service.');
                return $data;
            }
        }else{
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            $this->assign('group_id',$group_id);
            $this->assign('uid',$this->uid);
            return $this->fetch();
        }
    }


    /**
     * 编辑短信服务商
     */
    public function edit(){
        if (request()->isAjax()){
            if(request()->isPost()){
                $data = request()->post();
                $data['uid'] =isset($data['uid'])?$data['uid']:$this->uid;
                $model = new \app\common\model\Service();
                if($model->updateService($data)){
                    return ['status'=>true,'message'=>'短信服务商编辑成功'];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }else{
                $data['model']=Db::name('service')->find(request()->get('id'));
                $data['service']= Config::get('service.');
                return $data;
            }
        }else{
            $this->assign('edit_id',request()->get('id'));
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            $this->assign('group_id',$group_id);
            $this->assign('uid',$this->uid);
            return $this->fetch();
        }
    }


    /**
     * 删除短信服务商
     */
    public function remove(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result = Db::name('service')->where('uid',$this->uid)->delete($ids);
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            throw new HttpException(502,'请求不合法');
        }
    }


    public function send(){
        if(request()->isAjax()){
            $phone = request()->post('phones');
            $sid = request()->post('sid');
            $tid = request()->post('tid');

            //配置
            Db::name('service')->where('id',$sid)->where('uid',$this->uid)->update(['is_use'=>1]);
            Db::name('service')->where('id','<>',$sid)->where('uid',$this->uid)->update(['is_use'=>0]);

            //场景设置
            Db::name('template')->where('id',$tid)->where('uid',$this->uid)->update(['is_use'=>1]);
            Db::name('template')->where('id','<>',$tid)->where('uid',$this->uid)->update(['is_use'=>0]);

            $service =   Db::name('service')->find($sid);
            $template = Db::name('template')->find($tid);

            $send = SmsManager::getInstance($service['class_name']);
            $send->setConfig($service,$template);
            $res = $send->sendSms($phone,$this->uid);
            if ($res){
                return ['status'=>false,'message'=>'发送成功！'];
            }else{
                return ['status'=>false,'message'=>$send->getError()];
            }
        }else{
            $sid = request()->get('id');
            $template = Db::name('template')->where('sid',$sid)->where('uid',$this->uid)->select();
            $this->assign('template',$template);
            $this->assign('edit_id',$sid);
            return $this->fetch();
        }

    }

}