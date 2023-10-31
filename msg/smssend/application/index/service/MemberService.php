<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/22 19:24
 * for:
 */


namespace app\mobile\service;


use app\mobile\model\Member;
use app\mobile\traits\Result;
use think\Db;
use think\facade\Config;
use think\helper\Str;
use sms\Sms;

class MemberService
{

    use Result;

    protected static $member;

	/**
     * 用户登录
     * @param $data
     * @param \Closure|null $function
     * @return array|string
     */
    public static function login($data,\Closure $function = null){
		
        self::$member = Member::where('phone', $data['username'])->find();
		
		if(!self::$member){
			
			$msg = Result::error('手机号不存在');
			return $msg;
		}
		
		if(self::$member['password'] != md5($data['password'] . self::$member['token'])){
			
			$msg = Result::error('密码错误');
			return $msg;
		}
	
		if ($function != null) {
			
			$function(self::$member);
		}
		
		//登录完存session表示已经登录
		session('member',self::$member);

		//如果存在微信微信认证
        $url = session('wechat_auth')?url('auth/wechat'):null;
		return Result::success('登录成功',$url);
    }


    /**
     * 用户注册
     * @param $data
     * @param \Closure|null $function
     * @return array|string
     */
    public static function register($data,\Closure $function = null){

        $data['username'] = $data['phone'];

        //验证数据合法性
        $validate = validate('Member');

        if (!$validate->scene('register')->check($data)) {

            $msg = Result::error($validate->getError());
            return $msg;
        }
        $data['token'] = Str::random(10);
        $data['password'] = md5($data['password'] . $data['token']);
        $data['login_ip'] = \Util::get_client_ip(0, true);
        $data['register_time'] = date('Ymd');

        //获取注册渠道
        $data['channel_id'] = session('source');
        $model = new Member();
        $result = $model->save($data);

        //存在渠道注册来源--跳转下载地址
        $download = url('index/index');//session('source')>1?Config::get('download.url'):url('index/index');
        if ($result) {
            self::$member = Member::where('phone', $data['phone'])->find();

            //注册完存session表示已经登录
            session('member',self::$member);

            //清楚渠道来源的session
            session('source',null);

            //初始化info
            Db::name('member_info')->insert(['uid'=>self::$member['id']]);
            Db::name('identify')->insert(['uid'=>self::$member['id']]);

            if ($function != null) {
                $function(self::$member);
            }
        }
        return Result::success('注册成功',$download);
    }


    /**
     * 更改密码
     * @param $data
     * @return array|string
     */
    public static function changePass($data){
		
		self::$member = Member::where('phone', $data['phone'])->find();
			
		if(!self::$member){
				
			$msg = Result::error('手机号不存在');
			return $msg;
		}
			
		$ret = Sms::getInstance()->verifySmsCode($data['phone'],$data['verify']);
		
		if(!$ret){
		 
			return Result::error('验证码错误');
		}
			
						
		$newPwd = md5($data['password'] . self::$member['token']);
		
		$member['password'] = $newPwd;
		
		$model = new Member();
		
		$model->isUpdate(true)->save(self::$member);
		
		return Result::success('修改成功');
    }

}