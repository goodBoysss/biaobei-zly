<?php
/* Smarty version 3.1.33, created on 2020-06-15 11:20:31
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/blackip/black_list.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee6e8ff4e2818_14660466',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ac0054a036773e1ac61a5e3d33b4761c3a9d5a8' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/blackip/black_list.htm',
      1 => 1592191227,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ee6e8ff4e2818_14660466 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>系统配置</cite></a><span lay-separator="">/</span>
        <a><cite>黑名单管理</cite></a>
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
                                <input type="text" name="search_ip" placeholder="请输入IP" autocomplete="off" class="layui-input form-filter">
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
                            <th width="90px">操作</th>
                            <th>IP</th>
                            <th>状态</th>
                            <th>添加时间</th>
                            <th>更新时间</th>
                            <th width="50px">ID</th>
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

<?php echo '</script'; ?>
>

<style>
    .btn-upgrade{cursor: pointer;color: #009688;}
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
            xbLayUi.open('添加黑名单', '/blackip/add', {width: '60%', height: '360px'});
        });
    }
    
    function editOne() {
        var id = $(this).attr('data-id');
        xbLayUi.open('编辑黑名单', '/blackip/edit?id='+id, {width: '60%', height: '360px'});
    }

    function deleteOne() {
        var id = $(this).data('id');
        layer.confirm('确认删除吗？', {
            btn: ['删除','取消'] //按钮
        }, function(){
            $.getJSON('/blackip/delete?id='+id,function (data) {
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

    function getBlackipsList(url) {
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/blackip/blackipsList?" + url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function (data) {
            var htmlData = '';
            htmlData += '<tr>';
            htmlData += '<td>' + optGroup(data.id, data.type) + '</td>';
            htmlData += '<td>' + data.ip + '</td>';
            htmlData += '<td align="left">' + (data.state == 1 ? '<span class="layui-badge layui-bg-green">启用</span>' : '<span class="layui-badge layui-bg-danger">关闭</span>') + '</td>';
            htmlData += '<td align="left">' + data.add_time + '</td>';
            htmlData += '<td align="left">' + data.update_time + '</td>';
            htmlData += '<td>' + data.id + '</td>';
            htmlData += '</tr>';
            return htmlData;
        };
        listDatas.listData();
        setTimeout(function () {
            $('.btn-edit').on('click', editOne);
            $('.btn-del').on('click', deleteOne);
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
