<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2019/4/1 12:02
 * For:
 */
return [
    'crypt' => 'dh2y',      //Crypt加密秘钥
    'auth_uid' => 'authId',      //用户认证识别号(必配)
    'not_auth_module' => 'admin/index,admin/pay', // 无需认证模块
    'user_auth_gateway' => 'index/login', // 默认网关
    'user_center' => ['member/index','sms/log','member/account','member/pay_log','sms/index','template/index']
];