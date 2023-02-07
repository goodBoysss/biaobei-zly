<?php
/* Smarty version 3.1.33, created on 2023-02-07 09:39:09
  from '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/staff/role.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63e1abbd41ff15_22313091',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4094da64353ce7fe8ff02ade268c0d209b9a5a4a' => 
    array (
      0 => '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/staff/role.htm',
      1 => 1589801249,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_63e1abbd41ff15_22313091 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="x-nav">
          <span class="layui-breadcrumb" style="visibility: visible;">
            <a href="">首页</a><span lay-separator="">/</span>
            <a href="">演示</a><span lay-separator="">/</span>
            <a>
              <cite>导航元素</cite></a>
          </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5"  onsubmit="searchInfo();return false;">
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input" autocomplete="off" placeholder="开始日" name="start" id="start" lay-key="1">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input" autocomplete="off" placeholder="截止日" name="end" id="end" lay-key="2">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon"></i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <!--
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                    -->
                    <button class="layui-btn" onclick="parent.xadmin.add_tab('添加角色','/staff/roleSave')"><i class="layui-icon"></i>添加</button>
                </div>
                <div class="layui-card-body " id="listDiv">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>角色名</th>
                            <th>拥有权限规则</th>
                            <th>描述</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
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
    $(document).ready(function(){
        staffGroupfList();
    });

    function staffGroupfList(url){
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/staff/groupList?"+url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function(data){
            var htmlData = '';
            htmlData += '<tr>';
            htmlData +='<td>'+data.group_id+'</td>';
            htmlData +='<td>'+data.group_name+'</td>';
            htmlData +='<td align="left">-</td>';
            htmlData +='<td align="left">'+data.note+' </td>';
            htmlData +='<td align="left">'+(data.is_delete==1?'<span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>':'<span class="layui-btn layui-btn-danger layui-btn-mini">被禁用</span>')+'</td>';
            htmlData +='<td align="center">';
            htmlData +=optGroup(data.group_id);
//		   	htmlData +=' <a href="/staff/delete?staff_id='+data.staff_id+'" title="删除">删除</a> |';
            htmlData +='</td>';
            htmlData +='</tr>';
            return htmlData;
        }

        listDatas.listData();

    }

    function optGroup(id) {
        htmlData = '';
        htmlData += '<a title="编辑" onclick="xadmin.open(\'编辑\',\'/staff/roleSave?group_id='+id+'&is_layer=1\')" href="javascript:;">';
        htmlData += '<i class="layui-icon"></i>';
        htmlData += '</a>';
        htmlData += '<a title="删除" onclick="deleteGroup('+id+')" href="javascript:;">';
        htmlData += ' <i class="layui-icon"></i>';
        htmlData += '</a>';
        return htmlData;
    }


    //搜索查询
    function searchInfo(){
        listDatas.isSearch = 1 ;//是否是搜索
        listDatas.search = function(){

            var group_id=$("select[name='group_id'] option:selected").val();
            var username=$("input[name='username']").val();
            var truename=$("input[name='truename']").val();
            var is_super=$("select[name='is_super'] option:selected").val();
            var ifmod=$("select[name='ifmod'] option:selected").val();

            if(group_id) listDatas.params.push("group_id="+group_id);
            if(username) listDatas.params.push("username="+username);
            if(truename) listDatas.params.push("truename="+truename);
            if(is_super) listDatas.params.push("is_super="+is_super);
            if(ifmod) listDatas.params.push("ifmod="+ifmod);
        }
        staffGroupfList();

        return false;
    }


    //删除
    function  deleteGroup(group_id){
        layer.confirm('确定要删除该用户吗？',function(index){
            $.post("/staff/delGroupOne","group_id="+group_id,function(data){
                if(data.delete_count==1){
                    layer.msg('删除成功',{icon: 1});
                    staffGroupfList();
                }else{
                    layer.msg(data.error,{icon: 2});
                }
            },"json");
        });
    }
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:common/footer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
