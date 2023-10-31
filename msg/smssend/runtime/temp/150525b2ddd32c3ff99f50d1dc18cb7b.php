<?php /*a:3:{s:51:"D:\php\smssend\application\admin\view\sms\send.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
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
    <title>发送短信</title>
    <link href="/static/admin/css/jquery.searchableSelect.css" rel="stylesheet" type="text/css">
</head>
<body>
<article class="cl pd-20">
    <form class="form form-horizontal" id="form-admin">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>模板：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 
                <select class="" id="template_id" name="template_id" onchange="getTemplateContent();">
                    <option  value="">请选择</option>
                    <?php foreach($template as $k=>$v): ?>
                    <option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['template_name']); ?></option>  
                    <?php endforeach; ?>
                </select>
                 
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">模板内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <span id="template_content"></span>
                 
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>群组：</label>
            <div class="formControls col-xs-8 col-sm-9">
                
                    <select class=""  id="tag" name="tag">
                        <option  value="">请选择</option>
                        <?php foreach($tag as $k=>$v): ?>
                        <option value="<?php echo htmlentities($v); ?>"><?php echo htmlentities($v); ?></option>  
                        <?php endforeach; ?>
                    </select>
                 
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">发送手机号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea type="text" id="phones" placeholder="多个手机号请用逗号(,)隔开" class="input-text" name="phones" style="height: 100px"></textarea>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" onclick="doSubmit()" value="发送短信">
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
<script src="/static/admin/js/jquery-1.11.1.min.js"></script>
<script src="/static/admin/js/jquery.searchableSelect.js"></script>
<script>
    $(function(){
        $('#template_id').searchableSelect();
        $('#tag').searchableSelect();
    });
</script>
<script type="text/javascript">
    function getTemplateContent(){
        var template_id = $("#template_id option:selected").val();　　　　//获取选中项的值;
        console.log(template_id);
        if (template_id!=''){
            $.get("<?php echo url('sms/send'); ?>", {template_id:template_id}, function (data) {
                $('#template_content').html(data.message);
            }, 'json');
        }else{
            $('#template_content').html('');
        }
    }
    function doSubmit(){
        var template_id = $("#template_id option:selected").val();　　　　//获取选中项的值;
        var tag = $("#tag option:selected").val();
        var phones = $("#phones").val();
        $.post("<?php echo url('sms/send'); ?>", {template_id:template_id,tag:tag,phones:phones}, function (data) {
            if (data.status == true) {
                layer.msg(data.message, function () {
                    parent.location.href="<?php echo url('sms/index'); ?>";
                    //layer_close();
                })
            } else {
                layer.msg(data.message);
            }
        }, 'json');
    }
    

</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>