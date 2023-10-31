<?php /*a:3:{s:57:"D:\php\smssend\application\admin\view\template\index.html";i:1625501250;s:55:"D:\php\smssend\application\admin\view\layout\_meta.html";i:1625501250;s:57:"D:\php\smssend\application\admin\view\layout\_footer.html";i:1625501250;}*/ ?>
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
    <title>短信模板</title>
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i>
    首页 <span class="c-gray en">&gt;</span>
    短信管理 <span class="c-gray en">&gt;</span>
    短信模板
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div id="table" class="page-container">
    <div class="text-c">
        <input type="text" class="input-text"  v-model="search.code" style="width:250px" placeholder="请输入模板编号" v-on:keyup.enter="btnSearch()">
        <input type="text" class="input-text"  v-model="search.message" style="width:250px" placeholder="请输入模板内容" v-on:keyup.enter="btnSearch()">
        <button type="submit" v-on:click="btnSearch()" class="btn btn-success" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" v-on:click="adminAdd()" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i>
                添加模板
            </a>
        </span>
        <span class="r">共有数据：<strong>{{count}}</strong> 条</span></div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="10">文章列表</th>
        </tr>
        <tr class="text-c">
            <th width="50">ID</th>
            <?php if($group_id == '1'): ?> <th width="100">模板类别</th><?php endif; ?>
            <th>模板名称</th>
            <th>模板编号</th>
            <th >模板内容</th>
            <th >服务商</th>
            <th >操作</th>
        </tr>
        </thead>
        <tbody>
        <tr class="text-c" v-for="(item,index)  in lists">
            <td>{{item.id}}</td>
            <?php if($group_id == '1'): ?>
            <td>
                <span class="label label-success radius" v-if="item.uid>0">当前账号使用</span>
                <span class="label radius" v-else>系统模板</span>
            </td>
            <?php endif; ?>
            <td>{{item.template_name}}</td>
            <td>{{item.code}}</td>
            <td>{{item.message}}</td>
            <td>{{item.name}}</td>
            <td class="td-manage">
                <a  v-if="show.remove" title="删除" v-bind:data-id="item.id" v-on:click="btnDel($event,index)" class="btn btn-danger radius size-MINI">
                    <i class="Hui-iconfont">&#xe6e2;</i>
                </a>
                <a v-if="show.edit" title="编辑" href="javascript:;" v-on:click="adminEdit(item)" class="btn btn-success radius size-MINI"><i
                        class="Hui-iconfont">&#xe6df;</i>
                </a>
                <a v-if="show.params" title="参数内容" href="javascript:;" v-on:click="adminParam(item)" class="btn  radius size-MINI"><i
                        class="Hui-iconfont">&#xe603;</i>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
    <!--vueJS分页---start-->
    <div class="pagination">
        <ul>
            <li v-if="current>1"><a v-on:click="current--,pageClick()">上一页</a></li>
            <li v-if="current==1"><a class="banclick">上一页</a></li>
            <li v-for="index in indexs"  v-bind:class="{ 'active': current == index}">
                <a v-on:click="btnClick(index)">{{ index }}</a>
            </li>
            <li v-if="current!=total"><a v-on:click="current++,pageClick()">下一页</a></li>
            <li v-if="current == total"><a class="banclick">下一页</a></li>
            <li><a>共<i>{{total}}</i>页</a></li>
        </ul>
    </div>
    <!--vueJS分页---end-->
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

<!--请在下方写此页面业务相关的脚本-->

<!--<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>-->
<script type="text/javascript">
    var models = {
        show:{},

        count:0,
        lists: [],//表格数据
        total:1, //总页数
        current:1,  //当前页码
        search:{}   //搜索框
    };

    var app_model = new Vue({
        el: "#table",
        data: models,
        mounted: function () {
            this.checkAuth();
        },
        methods: {
            //检测页面显示按钮权限
            checkAuth:function () {
                var auth = {
                    remove:'template/remove',
                    edit:'template/edit',
                    params:'template/params'
                };
                util.post("<?php echo url('index/auth'); ?>",auth,function (data) {
                    app_model.show = data;
                });
            },

            //上一页,下一页翻页
            pageClick: function(){
                initTable("<?php echo url('template/index'); ?>",this.current,this.search);
            },

            //点击页码
            btnClick: function(data){
                if(data != this.current){
                    this.current = data;
                    initTable("<?php echo url('template/index'); ?>",this.current,this.search);
                }
            },
            //添加按钮
            adminAdd:function () {
                var url = "<?php echo url('template/add'); ?>";
                admin_add('添加短信模板',url,'500','700');
            },


            //编辑
            adminEdit: function (item) {
                var url = "<?php echo url('template/edit'); ?>" + "?id=" + item.id;
                admin_edit('编辑短信模板', url, '500', '700');
            },

            adminParam:function (item) {
                var url = "<?php echo url('template/params'); ?>" + "?id=" + item.id;
                admin_edit('编辑模板参数', url, '', '600');
            },

            //删除按钮
            btnDel: function (event, index) {
                var _this = $(event.currentTarget);
                var id = _this.attr('data-id');
                admin_del("<?php echo url('template/remove'); ?>", id, index);
            },


            //搜索框搜索
            btnSearch:function () {
                initTable("<?php echo url('template/index'); ?>",this.current,this.search);
            }

        },

        //分页
        computed: {
            indexs: function () {
                var left = 1;
                var right = this.total;
                var ar = [];
                if (this.total >= 5) {
                    if (this.current > 3 && this.current < this.total - 2) {
                        left = this.current - 2;
                        right =left + 4;
                    } else {
                        if (this.current <= 3) {
                            left = 1;
                            right = 5;
                        } else {
                            right = this.total;
                            left = this.total - 4;
                        }
                    }
                }
                while (left <= right) {
                    ar.push(left);
                    left++;
                }
                return ar
            }
        }
    });
    //初始化数据表格
    initTable("<?php echo url('template/index'); ?>");
</script>
</body>
</html>