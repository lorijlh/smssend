<?php /*a:3:{s:55:"D:\php\smssend\application\admin\view\template\add.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
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
    <title>添加短信模板 - 短信模板管理</title>
</head>
<body>
<article class="cl pd-20">
    <form class="form form-horizontal" id="form-admin">
        <?php if($group_id == '1'): ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>模板类别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input value="<?php echo htmlentities($uid); ?>" type="radio" id="sex-1" v-model="model.uid">
                    <label for="sex-1">自己使用</label>
                </div>
                <div class="radio-box">
                    <input value="0" type="radio" id="sex-2"  v-model="model.uid">
                    <label for="sex-2">系统模板</label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">模板名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="请输入模板名称方便区分" v-model="model.template_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">模板ID：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="请输入使用场景如：442268" v-model="model.code">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>模板内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea type="text" class="input-text" v-model="model.message" style="height: 200px"></textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>短信服务商：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select class="select"  size="1" v-model="model.sid">
                        <option  value="">请选择短信服务商</option>
                        <option v-for="option in service" v-bind:value="option.id">{{option.name }}</option>
                    </select>
				</span>
            </div>
        </div>
        <div class="row cl">
            <div class="panel panel-default col-md-offset-2 col-xs-12 col-sm-12">
                <div class="panel-header">短信内容变量名称</div>
                <div class="panel-body">
                    <div class="row cl" v-for="(item,index)  in model.params">
                        <div class="formControls col-xs-8 col-sm-2">
                            <input type="text" class="input-text" placeholder="短信内容key" v-model="item.val">
                        </div>
                        <div  class="formControls col-xs-2 col-sm-1">
                            <a class="btn radius" v-on:click="AddOrDelParams(index)"><i class="Hui-iconfont Hui-iconfont-jianhao"></i></a>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="formControls col-xs-8 col-sm-1">
                            <a class="btn radius" v-on:click="AddOrDelParams()"><i class="Hui-iconfont Hui-iconfont-add"></i></a>
                        </div>
                    </div>


                </div>
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

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    var model = {
        uid:"<?php echo htmlentities($uid); ?>",
        template_name:'',
        code:'',
        message:'',
        sid:'',
        params:[]
    };

    var store_model = new Vue({
        el: "#form-admin",
        data: {
            model:model,
            service: []
        },
        methods: {
            //添加短信内容参数
            AddOrDelParams:function (index) {
                if (index>=0){
                    this.model.params.splice(index, 1)
                }else {
                    this.model.params.push({val:''});
                }
            },


            doSubmit: function() {
                $.ajax({
                    type:'post',
                    data:this.model,
                    url:"<?php echo url('template/add'); ?>",
                    cache: false,
                    dataType:'json',
                    success:function(data){
                        if(data.status==true){
                            layer.msg(data.message,function () {
                                parent.location.href="<?php echo url('template/index'); ?>";
                            })
                        }else {
                            layer.msg(data.message);
                        }
                    }
                });
            }
        }
    });

    //菜单模块
    util.get("<?php echo url('template/add'); ?>",function (data) {
        store_model.service = data;
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>