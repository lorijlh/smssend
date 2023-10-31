<?php
/**
 * Created by dailinlin.
 * Date: 2017/9/23 14:40
 * for: 后台公共 控制器
 */
 //
namespace app\common\controller;


use think\Controller;
use think\Db;
use think\exception\ErrorException;
use think\facade\Config;
use think\facade\Request;
use think\helper\Str;
use think\facade\View;
use think\Hook;
use think\Model;

class BaseAdmin extends Controller
{

    protected $uid;

    protected function initialize(){
        $config = Config::get('login_admin.');
        $this->uid =  session($config['auth_uid']);
        //vip到期重置
        $vip_time = Db::name('admin')->where('id',$this->uid)->cache(600)->value('vip_time');
        if ($vip_time<time()){
            Db::name('admin')->where('id',$this->uid)->update(['vip'=>0]);
        }
        //短信数量
        $controller= Request::instance()->controller();
        $action    = Request::instance()->action();
        $url = Str::lower($controller.'/'.$action);
        $sms_num = Db::name('admin')->where('id',$this->uid)->value('num');
        $group_id = Db::name('auth_group_access')->where('uid',$this->uid)->value('group_id');
        if($group_id!=1&&$sms_num<=0&&!in_array($url,$config['user_center'])){
             if(Request::instance()->isAjax()){
                die(json_encode(['status'=>false,'message'=>'对不起您，你的短信数量不足!请前往个人中心购买短信']));
            }else{
                $view   = View::instance(Config::get('template'), Config::get('view_replace_str'));
                echo $view->fetch('common@layout/center');die;
            }
        }
    }

    /**
     * 自动获取搜索条件 组装
     * @param $table
     * @return $this|\think\db\Query
     */
    protected function where($table){
        $search = request()->except([Config::get('paginate.var_page'),'_'],'get');

        $model = Db::name($table);
        if(is_array($search)){
            foreach($search as $key=>$value){
                if($value!=''){
                    if(is_numeric($value)){
                        if($value>-1){
                            $model = $model->where($key,$value);
                        }
                    }else{
                        $time = explode(' - ',$value);
                        if(is_array($time)&&count($time)==2){ //如果是时间
                            $model = $model->whereBetween($key,[strtotime($time[0]),strtotime($time[1])]);
                        }else{
                            $model = $model->where($key,'like','%'.$value.'%');
                        }
                    }
                }
            }
        }
        return $model;
    }

    /**
     * 万能搜索
     * @param $table 表名
     * @param bool $page 是否分页 默认分页
     * @param array $cond 附加条件  $map['key'] = ['op','value']
     * @param string $desc
     * @param string $order
     * @return array|false|\PDOStatement|string|\think\Collection
     */
    protected function search($table,$page=true,$cond=[],$desc='desc',$order='id'){

        $search = request()->except([Config::get('paginate.var_page'),'_'],'get');
        if($table instanceof Model){
            if(method_exists($table,'search')){
                return $table->search($search);
            }else{
                new ErrorException(1,'模型不存在search方法',dirname(__FILE__),dirname(__LINE__ ));
            }
        }

        $model = Db::name($table);

        if(is_array($search)){
            foreach($search as $key=>$value){
                if($value!=''){
                    if(is_numeric($value)){
                        if($value>-1){
                            $model = $model->where($key,$value);
                        }
                    }else{
                        $time = explode(' - ',$value);
                        if(is_array($time)&&count($time)==2){ //如果是时间
                            if(is_int($time[0])&&is_int($time[1])&&$time[0]<10000000&&$time[1]<10000000){
                                $model = $model->whereBetween($key,[$time[0],$time[1]]);
                            }else{
                                $model = $model->whereBetween($key,[strtotime($time[0]),strtotime($time[1])]);
                            }
                        }else{
                            $model = $model->where($key,'like','%'.$value.'%');
                        }
                    }
                }
            }
        }

        //分页处理
        if ($page){
            //扩展的where条件
            foreach ($cond as $key=>$item){
               $model =  $model->where($key,$item[0],$item[1]);
            }
            $count = $model->count();
            $Page = new \VuePage($count);
            $lists = $model->limit($Page->getStart(),$Page->getEnd())->order($order,$desc)->select();
            $Page->setData($lists);
            return $Page->show();
        }else{

            return [
                'lists' =>$model->where($cond)->order($order,$desc)->select(),
                'count' => $model->where($cond)->count(),
                'total' => 1,
                'current' =>1,
                'size' => Config::get('paginate.list_rows')
            ];

        }

    }

}