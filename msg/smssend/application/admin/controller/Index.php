<?php
namespace app\admin\controller;


use dh2y\login\login;
use think\auth\Auth;
use think\auth\AuthManager;
use think\Db;
use think\facade\Config;
use think\Controller;
use think\facade\Session;
use think\helper\Str;

class Index extends Controller
{
    public function index(){
        $config = Config::get('login_admin.');

        //获取权限菜单
        $authManager = AuthManager::getInstance();
        $menus = $authManager->getAuthMenu(session($config['auth_uid']));

        $this->assign('menus_lists',$menus);

        //角色名称
        $auth = Auth::instance();
        $user_group = $auth->getGroups(session($config['auth_uid']));
        if(count($user_group)>0&&isset($user_group[0]['title'])){
            $this->assign('user_group',$user_group[0]['title']);
        }
        return $this->fetch();
    }


    /**
     * 登录页面
     */
    public function login(){
        if(request()->post()){
            $login = new login('admin');
            $data = request()->post();
            return $login->doLogin($data,function ($member){

                //将角色id存入session
                $group_id = Db::name('auth_group_access')->where('uid',$member['id'])->value('group_id');
                session("group_id", $group_id);
            });
        }
        return $this->fetch();
    }

    /**
     *记住用户名和密码
     */
    public function member(){
        $member = new login('admin');
        return $member->remember();
    }

    /**
     * 退出
     */
    public function logout(){
        $member = new login();
        $result = $member->logout();
        if($result['status']==true){
            $this->redirect('/');
        }
    }


    /**
     * 注册
     */
    public function register(){
        if(request()->post()){
            $data = request()->post();
            $model = new \app\admin\model\Admin();
            if($model->doRegister($data)){
                return ['status'=>true,'message'=>'注册成功'];
            }else{
                return ['status'=>false,'message'=>$model->getError()];
            }
        }
        return $this->fetch();
    }

    /**
     * 文件资源上传
     * @return array
     */
    public function upload()
    {
        $file = request()->file('file');

        if (!$file) {
            return ['status' => false, 'message' => '附件上传失败!'];
        }

        $path = 'upload';
        // 移动到框架应用根目录/public/uploads/ 目录下
        $name = date('Y-m-d') . '/' . md5(time() . Str::random(4));
        $info = $file->validate(['ext' => 'jpg,png,gif,jpeg'])->move($path, $name);
        if ($info) {
            $url = '/'.$path . '/' . $info->getSaveName();
            // 成功上传后 获取上传信息
            return ['status' => true, 'message' => '附件上传成功', 'path' => $url];
        } else {
            return ['status' => false, 'message' => $file->getError()];
        }
    }
}
