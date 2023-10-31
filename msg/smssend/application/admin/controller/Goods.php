<?php


namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\Db;

class Goods extends BaseAdmin
{
    /**
     * 文章列表
     */
    public function index(){
        if (request()->isAjax()){
            $list = $this->search('goods');
            return $list;
        }else{
            return $this->fetch();
        }
    }
    /**
     * 文章添加
     */
    public function add(){
        if (request()->isAjax()){
            $data = request()->post();
            $model=new \app\common\model\Goods();
            if($model->insertGoods($data)){
                return ['status'=>true,'message'=>'添加成功'];
            }else{
                return ['status'=>false,'message'=>$model->getError()];
            }
        }else{
            return $this->fetch();
        }
    }
    /**
     * 文章编辑
     */
    public function edit(){
        if (request()->isAjax()){
            if(request()->isGet()){
                $data['model'] = Db::name('goods')->find(request()->get('id'));
                return $data?$data:false;
            }else{
                $data = request()->post();

                $model = new \app\common\model\Goods();
                if($model->updateGoods($data)){
                    return ['status'=>true,'message'=>'编辑成功'];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }
        }else{
            $this->assign('edit_id',request()->get('id'));
            return $this->fetch();
        }
    }
    /**
     * 文章删除
     */
    public function remove(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result = Db::name('goods')->where('id','in',$ids)->delete();
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            throw new \HttpException(502,'请求不合法');
        }
    }


    /**
     * 更改管理员状态
     * @return array
     */
    public function status(){
        if(request()->isAjax()){
            $data = request()->post();
            $message = $data['state']==1?'上架':'下架';
            $result = Db::name('goods')->update($data);
            if($result){
                return ['status'=>true,'message'=>$message.'成功!'];
            }else{
                return ['status'=>false,'message'=>$message.'失败!'];
            }
        }else{
            throw new \HttpException(502,'请求不合法');
        }
    }
}