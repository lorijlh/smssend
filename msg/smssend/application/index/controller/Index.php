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