<?php
 //
namespace app\admin\controller;


use app\common\controller\BaseAdmin;
use think\Db;
use think\exception\HttpException;
use think\facade\Config;
use think\facade\Env;


class Tag extends BaseAdmin
{
    /**
     * 文章短信服务商列表
     */
    public function index(){
        if (request()->isAjax()){
        	$model = Db::name('phone');
        	$cond = [];
        	$param = request()->except([Config::get('paginate.var_page'),'_'],'get');
        	if (isset($param['tag']) && $param['tag']) {
        		$cond[] = ['tag','=',$param['tag']];
        	}
            $count = $model->where('uid',$this->uid)->where($cond)->group('tag')->count();
            $Page = new \VuePage($count);
            $lists = Db::name('phone')->field('tag,count(*) as number')->where('uid',$this->uid)->where($cond)->group('tag')->select();
            $Page->setData($lists);

            return $Page->show();
        }else{
            return $this->fetch();
        }
    }


}