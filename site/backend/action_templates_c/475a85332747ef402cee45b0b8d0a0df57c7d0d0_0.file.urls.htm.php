<?php
/* Smarty version 3.1.33, created on 2023-02-06 18:21:51
  from '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/urls/urls.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63e0d4bf3de705_65924832',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '475a85332747ef402cee45b0b8d0a0df57c7d0d0' => 
    array (
      0 => '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/urls/urls.htm',
      1 => 1592315763,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_63e0d4bf3de705_65924832 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>链接管理</cite></a><span lay-separator="">/</span>
        <a><cite>短网址列表</cite></a>
    </span>
    <span style="float: right;">
        <div class="btn-group">

        </div>
    </span>
</div>


<style>
    .btn-changeStatus{
        cursor: pointer;
    }
</style>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md2">
            <div class="layui-card">
                <div class="layui-card-header">短域名列表</div>
                <div class="layui-card-body" id="shortAddrList">
                    <div class="layui-col-md12" style="margin-bottom: 10px">
                        <div class="layui-inline" style="width: 80%">
                            <input placeholder="搜索..." id="shortUrl" name="shortUrl" autocomplete="off" value="" class="layui-input">
                        </div>
                        <button id="shortUrlSearch" class="layui-btn" style="width: 20%;margin-left: -5px;"><i class="layui-icon layui-icon-search"></i></button>
                    </div>
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>短链地址</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="layui-col-md10">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <div style="float: left;">
                        <form class="layui-form layui-col-space5" onsubmit="searchInfo();return false;">
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="search_url" placeholder="原始网址" autocomplete="off" class="layui-input form-filter">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="search_surl" placeholder="短网址" autocomplete="off" class="layui-input form-filter">
                            </div>
                            <div class="layui-inline" style="width: 90px;">
                                <select name="search_status" class="form-filter" lay-filter="form-filter">
                                    <option value="">状态</option>
                                    <option value="1">有效</option>
                                    <option value="0">无效</option>
                                </select>
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
                                <th width="50px">ID</th>
                                <th>原始网址</th>
                                <th>短网址</th>
                                <th>状态</th>
                                <th width="50px">点击数</th>
                                <th>添加时间</th>
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
    var domainUrl = '';
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
        // listDatas.dataSourceCallback = 'getShortAddrsList';
        // listDatas.doSearch();
        getShortAddrsList();

        setTimeout(function () {
            $("#shortAddrList table tr td:eq(0)").click();
        },200)
    }
    

    function bindEvent() {
        //绑定切换短域名
        $("#shortAddrList table ").on('click','td',changeDomain);
        //短域名搜索
        $("#shortUrlSearch").on('click',shortUrlSearch);
    }

    //切换短域名
    function changeDomain() {
        $("#shortAddrList table tr td").css({backgroundColor:'#fff',color:"#000"});
        $(this).css({backgroundColor:'#009688',color:"#fff"});
        domainUrl = $.trim($(this).html());
        getUrlsList("s_url="+encodeURI(domainUrl));
    }

    //短网址搜索
    function shortUrlSearch(){
        var _sDomain = $.trim($("#shortUrl").val());
        getShortAddrsList("short_url="+encodeURI(_sDomain))

        setTimeout(function () {
            $("#shortAddrList table tr td:eq(0)").click();
        },200)
    }

    //获取短域名列表
    function getShortAddrsList(url) {
        listDatas.containerID = '#shortAddrList table thead:first';
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/urls/shortAddrsList?" + url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function (data) {
            var htmlData = '';
            htmlData += '<tr>';
            htmlData += '<td>' + data.short_url + '</td>';
            htmlData += '</tr>';
            return htmlData;
        };
        listDatas.listData(false);
    }

    function getUrlsList(url) {
        if(url==undefined){
            url = "s_url="+encodeURI(domainUrl);
        }
        listDatas.dataSourceCallback = "getUrlsList";
        listDatas.containerID = '#listDiv table thead:first';
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/urls/urlsList?" + url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function (data) {
            var htmlData = '';
            htmlData += '<tr>';
            htmlData += '<td>' + data.id + '</td>';
            htmlData += '<td>' + data.url + '</td>';
            htmlData += '<td>' + data.short_url + '</td>';
            htmlData += '<td>' + (data.status?'<span class="layui-badge layui-bg-green btn-changeStatus" data-url="'+data.short_url+'" data-status="1">有效</span>':'<span class="layui-badge  btn-changeStatus" data-url="'+data.short_url+'" data-status="0">无效</span>') + '</td>';
            htmlData += '<td>' + data.count + '</td>';
            htmlData += '<td>' + data.create_at + '</td>';
            htmlData += '</tr>';
            return htmlData;
        };
        listDatas.listData();

        listDatas.loadComplete = function(){
            $('.btn-changeStatus').on('click',changeStatus);
        }

    }

    function changeStatus() {
        var obj = $(this);
        var status = obj.attr('data-status')==1?0:1;
        var shortUrl = obj.attr('data-url');
        $.getJSON('/urls/urlStatus',{'url':shortUrl,'status':status},function (data) {
            if(data.msg){
                layer.msg(data.msg, {icon: 1});
                if(status==0){
                    obj.removeClass('layui-bg-green').attr('data-status',0).html("无效")
                }else{
                    obj.addClass('layui-bg-green').attr('data-status',1).html('有效')
                }
            }else{
                layer.msg(data.error, {icon: 2});
            }
        });
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
