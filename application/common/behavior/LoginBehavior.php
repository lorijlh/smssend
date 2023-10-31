<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2018/4/24 0024 18:18
 * For: 登录检测行为
 */

namespace app\common\behavior;


use think\facade\Request;
use think\helper\Str;


class LoginBehavior
{

    use \traits\controller\Jump;//类里面引入jump;类

    public function run($params){
        $admin = new \dh2y\login\login();

        $login = session($admin->auth_uid);

        //获取当前模块
        $request= Request::instance();
        $module    = $request->module();
        $controller=$request->controller();
        $action = $request->action();

        //后台首页
        $url  = Str::lower($controller.'/'.$action);
        if($url=='index'.'/'.'index'&&!isset($login)){
            $this->redirect(url($admin->user_auth_gateway));
        }


        //获取无需认证模块配置
        $modules = explode(',',$admin->not_auth_module);
        if(!in_array(Str::lower($module.'/'.$controller),$modules)&&!isset($login)){
            $this->redirect(url($admin->user_auth_gateway));
        }

    }
}