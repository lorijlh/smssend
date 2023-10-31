<?php /*a:3:{s:55:"D:\php\smssend\application\admin\view\service\send.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
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
    <title>编辑短信模板 - 短信模板管理</title>
</head>
<body>
<article class="cl pd-20">
    <form class="form form-horizontal" id="form-admin">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>发送手机号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea type="text" placeholder="多个手机号请用逗号隔开 ," class="input-text" v-model="model.phones" style="height: 200px"></textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>短信服务商：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select class="select"  size="1" v-model="model.tid">
                        <option  value="">请选择短信服务商</option>
                        <?php if(is_array($template) || $template instanceof \think\Collection || $template instanceof \think\Paginator): $i = 0; $__LIST__ = $template;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['template_name']); ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
				</span>
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
        sid:"<?php echo htmlentities($edit_id); ?>",
        tid:'',
        phones:''
    };

    var store_model = new Vue({
        el: "#form-admin",
        data: {
            model:model,
            service: []
        },
        methods: {

            doSubmit: function() {
                $.ajax({
                    type:'post',
                    data:this.model,
                    url:"<?php echo url('service/send'); ?>",
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

</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>