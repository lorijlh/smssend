<?php /*a:3:{s:50:"D:\php\smssend\application\admin\view\sms\add.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
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
    <title>导入手机号 - 发送人</title>
</head>
<body>
<article class="cl pd-20">
    <form class="form form-horizontal" id="form-admin">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">批量导入模板</label>
            <div class="formControls col-xs-8 col-sm-9">
                <a href="/联系人导入模板.xls">导入模板下载</a>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">批量导入</label>
            <div class="formControls col-xs-8 col-sm-9">
                <a class="btn btn-primary radius" onclick="document.getElementById('up_file').click()">点击上传</a>
                <input id="up_file" type="file" style="display: none" v-on:change="upFile()">
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

    };
    var store_model = new Vue({
        el: "#form-admin",
        data: {
            model:model
        },
        mounted: function () {

        },
        methods: {

            //上传图片
            upFile:function () {
                var _this = this;
                layer.load();
                upImage("<?php echo url('sms/add'); ?>", 'up_file', function (ret) {
                    layer.closeAll('loading');
                    if (ret.status == true) {
                        layer.msg(ret.message);
                        _this.batchAdd(ret.data,0);
                    }
                })
            },

            batchAdd:function (total,have) {
                var _this = this;
                util.get("<?php echo url('sms/add'); ?>",{total:total,have:have},function (res) {
                        if (res.status == true){
                            if (res.have <= res.data){
                                layer.msg(res.message,function () {
                                    _this.batchAdd(res.data,res.have);
                                },1000);
                            }else {
                                parent.location.href="<?php echo url('sms/index'); ?>";
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