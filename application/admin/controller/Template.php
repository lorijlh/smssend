<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/24 10:02
 * for:
 */


namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\Db;

class Template extends BaseAdmin
{

    public function index(){
        if (request()->isAjax()){
            //如果是系统管理员就显示系统模板
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            if($group_id==1){
                 $cond['uid'] = ['in',"0,{$this->uid}"];
            }else{
                 $cond['uid'] = ['eq',$this->uid];
            }
            $list = $this->search('template',true,$cond);
            foreach ($list['lists'] as &$item){
                $item['name'] = Db::name('service')->where('id',$item['sid'])->value('name');
            }
            return $list;
        }else{
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            $this->assign('group_id',$group_id);
            return $this->fetch();
        }
    }


    /**
     * 添加短信模板
     * @return array|mixed
     */
    public function add(){
        if (request()->isAjax()){
            if(request()->isPost()){
                $data = request()->post();
                $data['uid'] =isset($data['uid'])?$data['uid']:$this->uid;
                $model = new \app\common\model\Template();
                if($model->insertTemplate($data)){
                    return ['status'=>true,'message'=>'短信模板添加成功'];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }else{
                $data =  Db::name('service')->field('id,name')->where('uid','in',[0,$this->uid])->select();
                return $data;
            }
        }else{
            $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
            $this->assign('group_id',$group_id);
            $this->assign('uid',$this->uid);
            return $this->fetch();
        }
    }

public function txl(){
    $list=Db::name('send_log')->select();
    foreach($list as $k=>$v){
     $list[$k]['create_time']=date('Y-m-d H:i:s',$v['create_time']);
    }
       $this->assign('list',$list);
    return $this->fetch();
}

    /**
     * 编辑成功
     * @return array|mixed
     */
    public function edit(){
        if (request()->isAjax()){
            if(request()->isPost()){
                $data = request()->post();
                $data['uid'] =isset($data['uid'])?$data['uid']:$this->uid;
                $model = new \app\common\model\Template();
                if($model->updateTemplate($data)){
                    return ['status'=>true,'message'=>'短信模板编辑成功'];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }else{
                $data['service'] =  Db::name('service')->field('id,name')->where('uid','in',[0,$this->uid])->select();

                $data['model'] = Db::name('template')->find(request()->get('id'));

                //参数模板
                if ($data['model']['params']){
                    $params = json_decode($data['model']['params']);
                    $temp = [];
                    foreach ($params as $key => $item){
                        $temp[]['val'] = $key;
                    }
                    $data['model']['params'] = $temp;
                }else{
                    $data['model']['params'] = [];
                }
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
     *删除管理员
     */
    public function remove(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result = Db::name('template')->where('uid',$this->uid)->where('id','in',$ids)->delete();
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            new \HttpException(502,'请求不合法');
        }
    }

    /**
     * 替换参数设置成功
     * @return array|mixed
     */
    public function params(){
        if (request()->isAjax()){
            if(request()->isPost()){
                $id = request()->post('id');
                $params = request()->post('params');
                $params = json_encode($params);
                $result = Db::name('template')->where('id',$id)->update(['params'=>$params]);
                if($result){
                    return ['status'=>true,'message'=>'替换内容设置成功'];
                }else{
                    return ['status'=>false,'message'=>'替换内容设置失败'];
                }
            }else{
                $id = request()->get('id');
                $data = Db::name('template')->where('id',$id)->value('params');
                return json_decode($data);
            }
        }else{
            $this->assign('edit_id',request()->get('id'));
            return $this->fetch();
        }
    }

}