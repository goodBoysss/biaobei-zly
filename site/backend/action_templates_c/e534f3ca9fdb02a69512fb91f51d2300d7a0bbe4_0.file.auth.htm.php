<?php
/* Smarty version 3.1.33, created on 2023-02-07 09:39:11
  from '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/staff/auth.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63e1abbf412af0_56075161',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e534f3ca9fdb02a69512fb91f51d2300d7a0bbe4' => 
    array (
      0 => '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/staff/auth.htm',
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
function content_63e1abbf412af0_56075161 (Smarty_Internal_Template $_smarty_tpl) {
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
                <div class="layui-card-header">
                    <button class="layui-btn" onclick="xadmin.open('添加权限(一级权限)','/staff/authSave?is_layer=1',800,480)" ><i class="layui-icon"></i>添加</button>
                </div>

                <div class="layui-card-body " id="treeCon" style="padding-bottom: 30px;">
                    <table class="layui-table layui-form" id="treeTable" lay-filter="treeTable" >
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>


<?php echo '<script'; ?>
>
$(document).ready(function(){

});
var editObj=null,ptable=null,treeGrid=null,tableId='treeTable',layer=null;
layui.config({
    base: '/lib/layui/extend/treeGrid/'
}).extend({
    treeGrid:'treeGrid'
}).use(['jquery','treeGrid','layer'], function(){
    var $=layui.jquery;
    treeGrid = layui.treeGrid;//很重要
    layer=layui.layer;
    ptable=treeGrid.render({
        id:tableId
        ,elem: '#'+tableId
        ,idField:'sr_menu_id'
        ,url:'/staff/rightMenus' //'http://bg.lg2.lh/data2.json'
        ,cellMinWidth: 100
        ,treeId:'sr_menu_id'//树形id字段名称
        ,treeUpId:'parent_id'//树形父id字段名称
        ,treeShowName:'right_name'//以树形式显示的字段
        ,iconOpen:false//是否显示图标【默认显示】
        ,isOpenDefault:false//节点默认是展开还是折叠【默认展开】
        ,loading:true
        ,cols: [[
//            {width:150,title: '操作', align:'center'/*toolbar: '#barDemo'*/
//                ,templet: function(d){
//                    var html='';
//                    var addBtn='<a class="layui-btn layui-btn layui-btn-xs" lay-event="add">添加</a>';
//                    var modBtn='<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="mod">编辑</a>';
//                    var delBtn='<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
//                    return addBtn+modBtn+delBtn;
//                }
//            },
            {field:'right_name',/* edit:'text',*/width:300 ,/*title: '权限名称'*/templet:function(data) {
                    //console.log('===',data)
                    var html = '';
                    if(data.level<3)html += '<i class="layui-btn layui-btn-xs layui-icon layui-icon-add-1" lay-event="add"></i>';
                    html += '<i class="layui-btn layui-btn-normal layui-btn-xs layui-icon layui-icon-edit" lay-event="mod"></i>';
                    html += '<i class="layui-btn layui-btn-danger layui-btn-xs layui-icon layui-icon-delete" lay-event="del"></i>';
                    return "├─ "+html+"【"+data.right_name+"】";
                }
            }
            ,{field:'right_code',width:100, title: '权限码'}
            ,{field:'note', title: '备注'}
            ,{field:'url', title: '地址'}
            ,{field:'sort_num', title: '排序值'}
        ]]
        ,page:false
    });

    treeGrid.on('tool('+tableId+')',function (obj) {
        var id  = obj.data.sr_menu_id;
        var level= Utils.isInt(obj.data.level)?parseInt(obj.data.level):1;
        var parent_id= obj.data.parent_id;

        if(obj.event === 'del'){//删除行
            //alert(JSON.stringify(obj.data) );
            deleteRightMenu(id);
        }else if(obj.event==="add"){//添加行
            xadmin.open('添加（上级权限：'+obj.data.right_name+')','/staff/authSave?is_layer=1&parent_id='+id+'&level='+level,800,480)
            //alert(JSON.stringify(obj.data) );
        }else if(obj.event==="mod"){//编辑行
            xadmin.open('编辑权限'+obj.data.right_name,'/staff/authSave?is_layer=1&parent_id='+parent_id+'&level='+level+'&sr_menu_id='+id,800,480)
            //alert(JSON.stringify(obj.data) );
        }
    });

    $('#treeCon').height('auto')

});

function query() {
    treeGrid.query(tableId,{
        where:{
            right_name:'查看'
        }
    });
}

function reload() {
    treeGrid.reload(tableId,{
        page:{
            curr:1
        }
    });
}

//删除
function  deleteRightMenu(sr_menu_id){
    layer.confirm('确定要删除该权限吗？',function(index){
        $.post("/staff/delRightMenusOne","sr_menu_id="+sr_menu_id,function(data){
            if(data.delete_count==1){
                layer.msg('删除成功',{icon: 1});
                reload();
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
