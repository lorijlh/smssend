<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2018/4/27 0027 22:36
 * For: 权限检测行为
 */

namespace app\common\behavior;


use think\auth\Auth;
use think\facade\Config;
use think\facade\Request;
use think\helper\Str;
use think\facade\View;

class AuthBehavior
{


    public function run($params){
        //获取当前模块
        $request   = Request::instance();
        $module    = $request->module();
        $controller= $request->controller();
        $action    = $request->action();
        $url = Str::lower($module.'/'.$controller.'/'.$action);


        $auth = Auth::instance();
        $config = Config::get('login_admin.');

        //如果请求的路由是  'index/auth'
        if(Str::lower($controller.'/'.$action)=='index/auth'){
            $auth = Auth::instance();
            $config = Config::get('login_admin.');
            $uid =  session($config['auth_uid']);

            $return = [];
            $check = $request->post();
            foreach ($check as $key => $value){

                $is_route = count(explode('/',$value))>1?true:false;

                //如果是路由
                if($is_route){
                    $url = Str::lower($module.'/'.$value);
                }else{
                    $url = $value;
                }
                $return[$key] = $auth->check($url, $uid);
            }
            die(json_encode($return));
        }


        //获取无需认证模块配置
        $modules = explode(',',$config['not_auth_module']);
        if(!in_array(Str::lower($module.'/'.$controller),$modules)&&!$auth->check($url, session($config['auth_uid']))){
            if($request->isAjax()){
                die(json_encode(['status'=>false,'message'=>'对不起您没有该操作权限!']));
            }else{
                $view   = View::instance(Config::get('template'), Config::get('view_replace_str'));
                echo $view->fetch('common@layout/access_denied');die;
            }
        }
    }
}