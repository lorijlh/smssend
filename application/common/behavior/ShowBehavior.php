<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2018/4/27 0027 22:36
 * For: 页面显示检测行为 批量检测权限
 */

namespace app\common\behavior;


use think\auth\Auth;
use think\facade\Config;
use think\facade\Request;
use think\helper\Str;
use think\facade\View;

class ShowBehavior
{


    public function run($params){
        //获取当前模块
        $request   = Request::instance();
        $module    = $request->module();
        $controller= $request->controller();
        $action    = $request->action();

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

    }
}