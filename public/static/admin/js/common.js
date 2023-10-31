/*
 后台-增加
 title	标题
 url		请求的url
 w		弹出层宽度（缺省调默认值）
 h		弹出层高度（缺省调默认值）
 */
function admin_add(title,url,w,h){
    layer_show(title,url,w,h);
}


/*后台编辑*/
function admin_edit(title,url,w,h){
    layer_show(title,url,w,h);
}


/*后台删除*/
function admin_del(url,ids,vueIndex){
    layer.confirm('确认要删除吗？',function(index){
        util.post(url,{ids:ids},function (data) {
            if(data.status==true){
                if (vueIndex!=undefined){
                    app_model.lists.splice(vueIndex,1);
                    app_model.count--;
                    app_model.total = Math.ceil(app_model.count/app_model.size);
                    layer.msg(data.message,{icon:1,time:2000});
                }else {
                    layer.msg(data.message,{icon:1,time:2000},function () {
                        window.location.reload()
                    });
                }
            }else {
                layer.msg(data.message,{icon:2,time:3000});
            }
        });
    });
}


/**
 * 上传文件
 * @param url
 * @param select
 * @param callback
 */
function upImage(url,select,callback) {
    var data = new FormData();
    data.append("file", document.getElementById(select).files[0]);
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'JSON',
        cache: false,
        processData: false,
        contentType: false,
        success: function (ret) {
            callback(ret)
        }
    });
}

/**
 * 初始化表格列表数据
 * @param url 请求路径
 * @param page 当前页数
 * @param search 搜索参数
 */
function initTable(url,page,search) {
    //设置默认page为1
    if(page===undefined){
        page = 1;
    }
    var param = {page:page};
    if(search!==undefined){
        param = $.extend(param, search);
    }
    util.get(url,param,function (data) {
        app_model.lists = (data.lists ==undefined) ? app_model.lists : data.lists;
        app_model.total = (data.total ==undefined) ? app_model.total : data.total;
        app_model.current = (data.current ==undefined) ? app_model.current : data.current;
        app_model.count = (data.count ==undefined) ? app_model.count : data.count;
        app_model.size = (data.size ==undefined) ? app_model.size : data.size;
    })
}

/**
 * VueJS过滤器格式
 */
Vue.filter('timeFormat', function (time,formart) {
    var dateStr = new Date(time*1000);
    return dateFormat(dateStr, formart);
})

/**
 * 时间格式化
 * @param date  php时间精确到秒，js是到毫秒
 * @param fmt
 * @returns {*|string}
 */
function dateFormat(date, fmt)
{
    date = date == undefined ? new Date() : date;
    date = typeof date == 'number' ? new Date(date) : date;
    fmt = fmt || 'yyyy-MM-dd HH:mm:ss';
    var obj =
        {
            'y': date.getFullYear(), // 年份，注意必须用getFullYear
            'M': date.getMonth() + 1, // 月份，注意是从0-11
            'd': date.getDate(), // 日期
            'q': Math.floor((date.getMonth() + 3) / 3), // 季度
            'w': date.getDay(), // 星期，注意是0-6
            'H': date.getHours(), // 24小时制
            'h': date.getHours() % 12 == 0 ? 12 : date.getHours() % 12, // 12小时制
            'm': date.getMinutes(), // 分钟
            's': date.getSeconds(), // 秒
            'S': date.getMilliseconds() // 毫秒
        };
    var week = ['天', '一', '二', '三', '四', '五', '六'];
    for(var i in obj)
    {
        fmt = fmt.replace(new RegExp(i+'+', 'g'), function(m)
        {
            var val = obj[i] + '';
            if(i == 'w') return (m.length > 2 ? '星期' : '周') + week[val];
            for(var j = 0, len = val.length; j < m.length - len; j++) val = '0' + val;
            return m.length == 1 ? val : val.substring(val.length - m.length);
        });
    }
    return fmt;
}