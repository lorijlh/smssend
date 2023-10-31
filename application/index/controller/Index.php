<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/21 21:47
 * for:
 */
 //

namespace app\index\controller;


use app\common\model\Document;
use think\Db;


class Index extends Common
{

    public function index(){
        return $this->fetch();
    }


    /**
     * 技术文档
     * @return mixed|void
     */
    public function news(){
        if (request()->isAjax()){
            $list = Document::where('show',1)
                ->order(['create_time'=>'desc','id'=>'desc'])
                ->paginate(16);

            return show($list->toArray());
        }

        $this->setNav('news');
        return $this->fetch();
    }
public function send_log(){
    $list=Db::name('send_log')->where('zt',0)->group('phone')->select();
    foreach($list as $k=>$v){
     $list[$k]['create_time']=date('Y-m-d H:i:s',$v['create_time']);
    }
    return exit(json_encode($list));
}
public function send_find(){
     $id = request()->get('id');
    $list_find=Db::name('send_log')->where('id',$id)->find();  
    $list=Db::name('send_log')->where('phone',$list_find['phone'])->order('id asc')->select();
    $list2=Db::name('send_log')->where('sid',$list_find['phone'])->order('id asc')->select();
    foreach ($list as $k=>$v){
         $list[$k]['create_time']=date('Y-m-d H:i:s',$v['create_time']);
    }
    $arr=$list;
    if(!empty($list2)){
         foreach ($list2 as $ka=>$va){
         $list2[$ka]['create_time']=date('Y-m-d H:i:s',$va['create_time']);
    }
        $arr=array_merge($list,$list2);
    }
    return exit(json_encode($arr));
}
    /**
     * 文档详情
     * @return mixed
     */
    public function detail(){
        $this->setNav('news');

        $id = request()->get('id');
        $document = Document::get($id);
        $this->assign('document',$document);

        return $this->fetch();
    }

    public function about(){
        $this->setNav('about');
        return $this->fetch();
    }

}