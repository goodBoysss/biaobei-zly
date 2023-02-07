<?php
/* Smarty version 3.1.33, created on 2020-06-10 16:50:41
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/urls/short_addrs.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee09ee111e140_92213621',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c99c7b9288c1b96644a14b5adb7e353f8bc8845' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/urls/short_addrs.htm',
      1 => 1591779038,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ee09ee111e140_92213621 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>链接管理</cite></a><span lay-separator="">/</span>
        <a><cite>短域名列表</cite></a>
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
                                <input type="text" name="short_url" placeholder="请输入短域名" autocomplete="off" class="layui-input form-filter">
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
                            <th>操作</th>
                            <th>短域名地址</th>
                            <th>名称（表名）</th>
                            <th>Key</th>
                            <th>所属企业</th>
                            <th>状态</th>
                            <th>添加时间</th>
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
    var companyMaps = {
        "0":"公共",
        "7235":"杭州日思夜享数据科技有限公司",
        "7236":"杭州利伊享数据科技有限公司",
    }
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
        listDatas.dataSourceCallback = 'getShortAddrsList';
        listDatas.doSearch();
    }

    function bindEvent() {
        $('.btn-add').on('click', function () {
            xbLayUi.open('添加统计应用', '/urls/shortAddrAdd', {width: '60%', height: '360px'});
        });

        $('#batchDelete').on('click', function () {
            if ($('.cb-item-sub:checked').length > 0) {
                // 检查选择客户是否在同一企业下
                var _idsArr = new Array();
                $('.cb-item-sub:checked').each(function (i, n) {
                    _idsArr.push($(n).data('id'));
                });
                xbLayUi.layerIndex = layer.confirm('确定要批量删除选中的统计应用吗？', function (index) {
                    xbLayUi.close();
                    xbLayUi.loading('正在删除中...');
                    $.post("/application/delete", "ids=" + JSON.stringify(_idsArr), function (data) {
                        xbLayUi.close();
                        if (data.code != 0) {
                            xbLayUi.msg(data.msg, 'error');
                        } else {
                            xbLayUi.msg('批量删除成功~');
                            listDatas.doSearch();
                        }
                    }, "json");
                });
            } else {
                xbLayUi.msg('请至少选择一个条目', 'info');
            }
        });

        $(document).on('click', '.btn-edit', function () {
            var _id = $(this).data('id');
            xbLayUi.open('编辑短网址', '/urls/shortAddrEdit?id=' + _id, {width: '60%', height: '360px'});
        }).on('click', '.btn-del', function () {

            xbLayUi.msg('抱歉，功能暂未开通！','error');
            return false;

            var _id = $(this).data('id');
            xbLayUi.layerIndex = layer.confirm('确定要删除短网址吗？', function (index) {
                xbLayUi.close();
                xbLayUi.loading('正在删除中...');
                $.post("/urls/shortAddrDelete", "id=" + _id, function (data) {
                    xbLayUi.close();
                    if (data.code != 0) {
                        xbLayUi.msg(data.msg, 'error');
                    } else {
                        xbLayUi.msg('删除成功~');
                        listDatas.doSearch();
                    }
                }, "json");
            });
        });

    }

    function getShortAddrsList(url) {
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/urls/shortAddrsList?" + url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function (data) {
            var htmlData = '';
            htmlData += '<tr>';
            htmlData += '<td>' + optGroup(data.id, data.type) + '</td>';
            htmlData += '<td>' + data.short_url + '</td>';
            htmlData += '<td align="left">' + data.name + '</td>';
            htmlData += '<td align="left">' + data.sha1 + '</td>';
            htmlData += '<td align="left">' + companyMaps[data.company_id] + '</td>';
            htmlData += '<td align="left">' + (data.status == 1 ? '<span class="layui-badge layui-bg-green">是</span>' : '<span class="layui-badge layui-bg-danger">否</span>') + '</td>';
            htmlData += '<td align="left">' + (data.add_time ? data.add_time : '-') + '</td>';
            htmlData += '<td>' + data.id + '</td>';
            htmlData += '</tr>';
            return htmlData;
        };

        listDatas.listData();
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
