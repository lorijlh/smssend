<?php


namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\Db;

class Links extends BaseAdmin
{
    /**
     * 菜单列表
     * @return mixed
     */
    public function index(){
        if (request()->isAjax()){
            $list = $this->search('links',true);
            return $list;
        }else{
            return $this->fetch();
        }
    }


    /**
     * 添加短信模板
     * @return array|mixed
     */
    public function add(){
        if (request()->isAjax()){
            $data = request()->post();
            $model = new \app\common\model\Links();
            if($model->insertLinks($data)){
                return ['status'=>true,'message'=>'友链添加成功'];
            }else{
                return ['status'=>false,'message'=>$model->getError()];
            }
        }else{
            return $this->fetch();
        }
    }


    /**
     * 编辑成功
     * @return array|mixed
     */
    public function edit(){
        if (request()->isAjax()){
            if(request()->isPost()){
                $data = request()->post();
                $model = new \app\common\model\Links();
                if($model->updateLinks($data)){
                    return ['status'=>true,'message'=>'友链编辑成功'];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }else{
                $data['model'] = Db::name('links')->find(request()->get('id'));
                return $data;
            }
        }else{
            $this->assign('edit_id',request()->get('id'));
            return $this->fetch();
        }
    }


    /**
     * 删除菜单
     * @return array
     */
    public function remove(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result = Db::name('links')->where('id','in',$ids)->delete();
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            new \HttpException(502,'请求不合法');
        }
    }
}