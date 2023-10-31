<?php /*a:3:{s:55:"D:\php\smssend\application\admin\view\member\index.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
<title><?php echo Config::get('base.web_name'); ?></title>
<meta name="keywords" content="<?php echo Config::get('base.keywords'); ?>">
<meta name="description" content="<?php echo Config::get('base.description'); ?>">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/static/admin/hui/lib/html5shiv.js"></script>
<script type="text/javascript" src="/static/admin/hui/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/admin/hui/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/hui/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/hui/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/hui/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/admin/hui/static/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/css/page.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/css/admin.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/static/admin/hui/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
    <title>群发对象</title>
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i>
    首页 <span class="c-gray en">&gt;</span>
    个人中心 <span class="c-gray en">&gt;</span>
    我的账号
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div id="table" class="page-container">
    <div class="panel panel-warning  mt-20">
        <div class="panel-header">快捷键</div>
        <div class="panel-body">
            <a class="btn btn-primary-outline size-XL radius" href="<?php echo url('service/index'); ?>">短信服务商</a>
            <a class="btn btn-secondary-outline size-XL radius" href="<?php echo url('template/index'); ?>">短信模板</a>
            <a class="btn btn-success-outline size-XL radius" href="<?php echo url('sms/index'); ?>">群发对象</a>
            <a class="btn btn-warning-outline size-XL radius" href="<?php echo url('sms/log'); ?>">发送记录</a>
            <a class="btn btn-danger-outline  size-XL radius" href="<?php echo url('member/account'); ?>">财务明细</a>
        </div>
    </div>
    <div class="panel panel-default mt-20 ">
        <div class="panel-header">用户中心 ( 余额: {{member.balance}}元    剩余条数：{{member.num}})</div>
        <div class="panel-body" style="height: 140px">
            <div  class="col-xs-12 col-sm-12">
                <div class="col-xs-12 col-sm-2">
                    <i class="Hui-iconfont" style="font-size: 100px;">&#xe705;</i>
                </div>
                <div class="col-xs-12 col-sm-8 mt-20">
                    <p>姓名: {{member.admin_name}}</p>
                    <p>账号: {{member.username}}</p>
                    <p>邮箱：{{member.email}}</p>
                    <p>用户类型：
                        <a v-if="member.vip==0" class="btn btn-primary size-MINI radius">普通用户</a>
                        <a v-if="member.vip==1" class="btn btn-success size-MINI radius">会员用户</a>
                        <span v-if="member.vip==1">&nbsp;&nbsp;&nbsp;&nbsp;到期时间:</span>
                        <a v-if="member.vip==1" class="btn btn-warning size-MINI radius">  {{member.vip_time,'yyyy-MM-dd HH:mm:ss'|timeFormat}}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-success mt-20">
        <div class="panel-header">充值套餐</div>
        <div class="panel-body">
            <form class="form form-horizontal" id="form-admin">
                <div class="row cl">
                    <div class="formControls col-xs-8 col-sm-12">
                        <div v-for="(item,index)  in goods" class="col-xs-4 col-sm-2" v-on:click="selectMoney($event,item.id)">
                            <div class="recharge-goods">
                                <img v-if="recharge.goods_id==item.id" src="/static/admin/image/choosey.png" style="position:absolute;top:1px;right:15px;"/>
                                <img v-else src="/static/admin/image/choosey.png" style="position:absolute;top:1px;right:15px;display: none"/>
                                <a class="recharge-goods-title">{{item.title}}</a>
                                <hr class="recharge-goods-hr">
                                <a>价格{{item.price}}元  <span v-if="item.give>0">送 {{item.give}}天</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <div class="radio-box">
                        <input type="radio" id="radio-0" name="demo-radio1" v-model="recharge.type" value="usdt">
                        <label for="radio-0">USDT支付</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="radio-1" name="demo-radio1" v-model="recharge.type" value="bank">
                        <label for="radio-1">银行卡支付</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="radio-2" name="demo-radio1" v-model="recharge.type" value="alipay">
                        <label for="radio-2">支付宝</label>
                    </div>
                </div>
                <p class="mt-10"><input class="btn btn-block btn-success radius" v-on:click="adminAdd()" type="button" value="立即购买"></p>
            </form>
        </div>
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/admin/hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/hui/lib/laydate/laydate.js"></script>
<script type="text/javascript" src="/static/admin/hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/admin/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/admin/hui/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/static/admin/js/vue.js"></script>
<script type="text/javascript" src="/static/admin/util.js"></script>
<script type="text/javascript" src="/static/admin/js/common.js"></script>
<?php echo Config::get('base.statistical'); ?>

<!--/_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/admin/hui/lib/jquery.SuperSlide/2.1.1/jquery.SuperSlide.min.js"></script>
<!--请在下方写此页面业务相关的脚本-->


<script type="text/javascript">
    var models = {
        member:{},
        goods:{},
        recharge:{
            type:'usdt',
            goods_id:''
        }
    };

    var app_model = new Vue({
        el: "#table",
        data: models,
        mounted: function () {

        },
        methods: {
            selectMoney:function (event,id) {
                this.recharge.goods_id = id;
                var _this = $(event.currentTarget);
                $(_this).children('.recharge-goods').addClass('recharge-check');
                $(_this).children('.recharge-goods').children('img').show();
                $(_this).siblings().children('.recharge-goods').removeClass('recharge-check');
                $(_this).siblings().children('.recharge-goods').children('img').hide();
            },
            
            doSubmit: function () {
               window.open("<?php echo url('pay/recharge'); ?>?type="+this.recharge.type+"&goods_id="+this.recharge.goods_id)
            },

            adminAdd:function (page) {
                var url = "<?php echo url('pay/topay'); ?>?type=" + this.recharge.type + "&goods_id=" + this.recharge.goods_id;
                admin_add('充值',url,'800','500');
            },

        },

    });

    //初始化数据
    util.post("<?php echo url('member/index'); ?>",function (res) {
        app_model.member = res.data.member;
        app_model.goods = res.data.goods;
        app_model.recharge.goods_id = res.data.goods[0].id;
    });

</script>
</body>
</html>