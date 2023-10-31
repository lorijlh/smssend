<?php /*a:3:{s:54:"D:\php\smssend\application\admin\view\service\add.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
<!--_meta 作为公共模版分离出去-->
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
    <title>添加服务商</title>
</head>
<body>
<article class="cl pd-20">
    <form class="form form-horizontal" id="form-admin">
        <?php if($group_id == '1'): ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>服务商类别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input value="<?php echo htmlentities($uid); ?>" type="radio" id="sex-1" v-model="model.uid">
                    <label for="sex-1">自己使用服务商</label>
                </div>
                <div class="radio-box">
                    <input value="0" type="radio" id="sex-2"  v-model="model.uid">
                    <label for="sex-2">系统服务商</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否真发：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input value="1" type="radio" id="sex-1" v-model="model.is_test">
                    <label for="sex-1">测试</label>
                </div>
                <div class="radio-box">
                    <input value="0" type="radio" id="sex-2"  v-model="model.is_test">
                    <label for="sex-2">真发</label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>服务商名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="model.name" placeholder="请输入服务商名称">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>短信服务商：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <span class="select-box">
                    <select class="select"  size="1" v-model="model.class_name" v-on:change="toSelect()">
                        <option  value="">请选择服务商</option>
                        <option v-for="(option,index) in service" v-bind:value="index">{{option.name}}</option>
                    </select>
                 </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>短信account：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="model.account" placeholder="请输入短信account">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>短信key：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="model.password" placeholder="请输入短信key">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">短信signature：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="model.signature" placeholder="请输入短信signature">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">AppId：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="model.app_id" placeholder="请输入AppId  如果是云通讯必须">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" v-on:click="doSubmit()" value="提交">
            </div>
        </div>
    </form>
</article>

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
<script type="text/javascript">
    var model = {
        model: {
            name:'',
            class_name:'',
            account:'',
            password:'',
            signature:'',
            is_test:0,
            uid:"<?php echo htmlentities($uid); ?>"
        },
        service:[]
    };
    var store_model = new Vue({
        el: "#form-admin",
        data: model,
        methods: {
            toSelect:function(){
                this.model.type = this.service[this.model.class_name].type;
            },
            doSubmit: function () {
                $.ajax({
                    type: 'post',
                    data: this.model,
                    url: "<?php echo url('service/add'); ?>",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == true) {
                            layer.msg(data.message, function () {
                                parent.location.href="<?php echo url('service/index'); ?>";
                                //layer_close();
                            })
                        } else {
                            layer.msg(data.message);
                        }
                    }
                });
            }
        }
    });

    util.get("<?php echo url('service/add'); ?>", {id:"1"},function (data) {
        store_model.service = data.service;
    });

</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>