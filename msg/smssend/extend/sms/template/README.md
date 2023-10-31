模板类短信运营商
===============

> 运行环境要求PHP7.1+、框架thinkphp6.0。

## 无模板类配置

~~~
return [
    'IS_TEST' => true,             //是否测试默认验证码 111111
    //短信基本配置
    'SMS_SDK' =>[
        'class' => 'Smsbao',     //服务商
        'account' => 'a1010912488',   //服务商账户(这里的key值可以根据服务商而定不一定是account)
        'password'=> '1010912488coco',       //服务商密码(这里的key值可以根据服务商而定不一定是password)
        'signature' => '【指尖宝】'   //签名
    ],

    //验证码使用场景文案

    'SMS_SCENE' =>[
        'bind' =>'您的验证码为%code%，在3分钟内有效。',// 忘记密码
        'login' => '您的验证码为%code%，在3分钟内有效。',// 登陆注册短信验证码 短信模板TemplateCode
        'register' => '您的验证码为%code%，在3分钟内有效。',// 登陆注册短信验证码 短信模板TemplateCode
    ]
];
~~~
