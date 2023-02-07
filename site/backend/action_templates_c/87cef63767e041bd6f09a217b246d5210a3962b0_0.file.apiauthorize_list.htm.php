<?php
/* Smarty version 3.1.33, created on 2020-06-22 09:04:28
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/apiauthorize/apiauthorize_list.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ef0039cb8ffb3_24299396',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87cef63767e041bd6f09a217b246d5210a3962b0' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/apiauthorize/apiauthorize_list.htm',
      1 => 1592280229,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ef0039cb8ffb3_24299396 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>系统配置</cite></a><span lay-separator="">/</span>
        <a><cite>API授权管理</cite></a>
    </span>
    <span style="float: right;">
        <div class="btn-group">
            <button class="layui-btn btn-add"><i class="fa fa-plus"></i> 新建</button>
        </div>
    </span>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <div style="float: left;">
                        <form class="layui-form layui-col-space5" onsubmit="return false;">
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="search_name" placeholder="请输入授权名称" autocomplete="off" class="layui-input form-filter">
                            </div>
                            <div class="layui-inline">
                                <button class="layui-btn filter-search"><i class="fa fa-search"></i> 搜索</button>
                                <button class="layui-btn layui-btn-primary filter-reset"><i class="fa fa-refresh"></i> 重置</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-tools" style="float: right;">

                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="layui-card-body " id="listDiv">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th width="70px">操作</th>
                            <th>基本信息</th>
                            <th  width="330px">AK/SK</th>
                            <th>状态</th>
                            <th>有效期</th>
                            <th>访问类型</th>
                            <th>权限说明</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
>
var accessType = {
     1:'公开访问'
    ,2:'白名单'
}
var companyMaps = {
    "0":"公共",
    "7235":"杭州日思夜享数据科技有限公司",
    "7236":"杭州利伊享数据科技有限公司",
}
<?php echo '</script'; ?>
>

<style>
    .btn-upgrade{cursor: pointer;color: #009688;}
    .btn-refresh-aksk{cursor: pointer;}
</style>
<?php echo '<script'; ?>
>
    $(document).ready(function(){
        initTable();

        bindEvent();
    });

    function initTable() {
        // listDatas.headerBtnGroup([
        //     //'<a id="batchDelete" href="javascript:;"><i class="fa fa-trash" style="color: red;"></i> 批量删除</a>'
        // ]);
        listDatas.dataSourceCallback = 'getBlackipsList';
        listDatas.doSearch();
    }

    function bindEvent() {
        $('.btn-add').on('click', function () {
            xbLayUi.open('添加API权限', '/apiAuthorize/add', {width: '60%', height: '640px'});
        });
    }
    
    function editOne() {
        var id = $(this).attr('data-id');
        xbLayUi.open('编辑API权限', '/apiAuthorize/edit?id='+id, {width: '60%', height: '640px'});
    }

    function deleteOne() {
        layer.msg('暂不支持删除操作');
        return false;
        var id = $(this).data('id');
        layer.confirm('确认删除吗？', {
            btn: ['删除','取消'] //按钮
        }, function(){
            $.getJSON('/apiAuthorize/delete?id='+id,function (data) {
                if(data.msg){
                    layer.msg(data.msg, {icon: 1});
                    listDatas.doSearch();
                }else{
                    layer.msg(data.error, {icon: 2});
                }
            });
        }, function(){

        });

    }

    //重置AK/SK
    function refreshAkSk() {
        var id = $(this).data('id');
        var _this = this;
        layer.confirm('您确定要重置SK吗？重置之后客户端需更新才能使用。', {
            btn: ['重置','取消'] //按钮
        }, function(){
            $.getJSON('/apiAuthorize/refreshSK?id='+id,function (data) {
                if(data.msg){
                    layer.msg(data.msg, {icon: 1});
                    $(_this).prev().html(data.sk)
                    //listDatas.doSearch();
                }else{
                    layer.msg(data.error, {icon: 2});
                }
            });
        }, function(){

        });
    }

    function getBlackipsList(url) {
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/apiAuthorize/apiAuthorizeList?" + url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function (data) {
            var htmlData = '';
            htmlData += '<tr>';
            htmlData += '<td>' + optGroup(data.id, data.type) + '</td>';
            htmlData += '<td>授权名称:  '+ data.name + '<br>公司名称: ' + companyMaps[data.company_id] + '</td>';
            htmlData += '<td>ID: <span class="layui-badge">'+data.uuid+'</span></br>AK: <span class="layui-badge layui-bg-green">' + data.access_key + '</span>  <br>SK: <span class="layui-badge layui-bg-cyan">'+data.secret_key+'</span><span class="layui-badge layui-bg-blue btn-refresh-aksk" data-id="'+data.id+'"><i class="fa fa-refresh" title="点击重置SecretKey"></i></span></td>';
            htmlData += '<td align="left">' + (data.status == 1 ? '<span class="layui-badge layui-bg-green">启用</span>' : '<span class="layui-badge layui-bg-danger">关闭</span>') + '</td>';
            htmlData += '<td align="left">' + (data.expire=='0000-00-00 00:00:00'?'永不过期':data.expire) + '</td>';
            htmlData += '<td align="left">' + (data.access_type==2?'白名单列表：<br>'+data.white_list.replace(/,/g,'<br>'):'公开访问') + '</td>';
            htmlData += '<td>';
            htmlData += '每分钟最大请求数：<span class="layui-badge layui-bg-orange">'+(data.rate_minute>0?data.rate_minute:'不限制')+'</span><br>';
            htmlData += '每小时最大请求数：<span class="layui-badge layui-bg-green">'+(data.rate_hour>0?data.rate_hour:'不限制')+'</span><br>';
            htmlData += '每一天最大请求数：<span class="layui-badge layui-bg-cyan">'+(data.rate_day>0?data.rate_day:'不限制')+'</span><br>';
            htmlData += '每个月最大请求数：<span class="layui-badge layui-bg-blue">'+(data.rate_month>0?data.rate_month:'不限制')+'</span>';
            htmlData += '</td>';
            htmlData += '</tr>';
            return htmlData;
        };
        listDatas.listData();
        setTimeout(function () {
            $('.btn-edit').on('click', editOne);
            $('.btn-del').on('click', deleteOne);
            $('.btn-refresh-aksk').on('click', refreshAkSk);
        },500)
    }

    function optGroup(id, type) {
        var _action = [];
         _action.push(`<li><a class="btn-edit" href="javascript:;" data-id="${id}"><i class="fa fa-edit"></i> 编辑</a></li>`);
        //_action.push('<li role="separator" class="divider"></li>');
        _action.push(`<li><a class="btn-del" href="javascript:;" data-id="${id}"><i class="fa fa-trash-o" style="color:red;"></i> 删除</a></li>`);

        return listDatas.btnGroup(_action, id,undefined,false);
    }

    layui.use(['form', 'laydate'], function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:common/footer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
