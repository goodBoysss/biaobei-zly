<?php
/* Smarty version 3.1.33, created on 2019-06-03 12:01:30
  from '/project/php7/program/LGFramework2.1/site/backend/action_templates/staff/staff.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cf49b9a4bc325_10394706',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '59faba7c84a4c224fe96b2ca97d47bf1e19bd360' => 
    array (
      0 => '/project/php7/program/LGFramework2.1/site/backend/action_templates/staff/staff.htm',
      1 => 1559534488,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5cf49b9a4bc325_10394706 (Smarty_Internal_Template $_smarty_tpl) {
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
                    <form class="layui-form layui-col-space5" onsubmit="searchInfo();return false;">
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
                    <button class="layui-btn" onclick="parent.xadmin.add_tab('添加管理员','/staff/staffSave',true)"><i class="layui-icon"></i>添加</button>
                </div>
                <div class="layui-card-body " id="listDiv">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="" lay-skin="primary"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div>
                            </th>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>用户组</th>
                            <th>真实姓名</th>
                            <th>是否超级管理</th>
                            <th>是否启用</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['staffs']->value['items'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <tr>
                            <td>
                                <input type="checkbox" name="" lay-skin="primary"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['staff_id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['group_id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['truename'];?>
</td>
                            <td><i class="layui-icon layui-bg-<?php if ($_smarty_tpl->tpl_vars['v']->value['is_super'] == 1) {?>green<?php } else { ?>red<?php }?>"><?php if ($_smarty_tpl->tpl_vars['v']->value['is_super'] == 1) {?>&#xe605;<?php } else { ?>&#x1006;<?php }?></i></td>
                            <td class="td-status">
                                <span class="layui-btn layui-btn-<?php if ($_smarty_tpl->tpl_vars['v']->value['ifmod'] == 1) {?>normal<?php } else { ?>danger<?php }?> layui-btn-mini"><?php if ($_smarty_tpl->tpl_vars['v']->value['ifmod'] == 1) {?>已启用<?php } else { ?>被禁用<?php }?></span>
                            </td>
                            <td class="td-manage">

                            </td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
        getStaffList();
    });

    function getStaffList(url){
        listDatas.page_size = 10;
        listDatas.statichost = '';//服务器地址
        listDatas.colspan = 8; //合并行数
        listDatas.dataurl = "/staff/staffList?"+url; //请求数据url

        //添加数据列表
        listDatas.addOneData = function(data){
            var htmlData = '';
            htmlData += '<tr>';
            htmlData +='<td><input type="checkbox" name="" lay-skin="primary"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div></td>';
            htmlData +='<td>'+data.staff_id+'</td>';
            htmlData +='<td>'+data.username+'</td>';
            htmlData +='<td align="left">'+(data.group_id!=0?'group':'-')+'</td>';
            htmlData +='<td align="left">'+data.truename+'</td>';
            htmlData +='<td align="left">'+(data.is_super==1?'<i class="layui-icon layui-bg-green">&#xe605;</i>':'<i class="layui-icon layui-bg-red">&#x1006;</i>')+' </td>';
            htmlData +='<td align="left">'+(data.ifmod==1?'<span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>':'<span class="layui-btn layui-btn-danger layui-btn-mini">被禁用</span>')+'</td>';
            htmlData +='<td align="center">';
            htmlData +=optGroup(data.staff_id);
            htmlData +='</td>';
            htmlData +='</tr>';
            return htmlData;
        }

        listDatas.listData();

    }

    function optGroup(id) {
        htmlData = '';
        htmlData += '<a title="编辑" onclick="xadmin.open(\'编辑用户\',\'/staff/staffSave?is_layer=1&staff_id='+id+'\')" href="javascript:;">';
        htmlData += '<i class="layui-icon"></i>';
        htmlData += '</a>';
        htmlData += '<a title="删除" onclick="deleteStaff('+id+')" href="javascript:;">';
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
        getStaffList();

        return false;
    }


    layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

    /*用户-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){

            if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
            }

        });
    }



    //删除
    function  deleteStaff(staff_id){
        layer.confirm('确定要删除该用户吗？',function(index){
            $.post("/staff/delStaffOne","staff_id="+staff_id,function(data){
                if(data.delete_count==1){
                    layer.msg('删除成功',{icon: 1});
                    getStaffList();
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
