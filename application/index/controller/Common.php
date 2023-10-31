<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/21 21:48
 * for:
 */


namespace app\index\controller;


use app\common\model\Config;
use think\Controller;
use think\Db;

class Common extends Controller
{

    protected $member;

    protected function setNav($name='/'){
        $this->assign('this_nav',$name);
    }

    /**
     * 前台控制器初始化
     */
    protected function initialize()
    {
        $this->setNav();
        $links = Db::name('links')->where('state',1)->select();
        $this->assign('friend_links', $links);
    }

}