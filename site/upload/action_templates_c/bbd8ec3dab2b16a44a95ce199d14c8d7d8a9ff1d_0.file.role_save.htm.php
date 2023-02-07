<?php
/* Smarty version 3.1.33, created on 2019-06-02 23:33:16
  from '/project/php7/program/LGFramework2.1/site/backend/action_templates/staff/role_save.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cf45cbc92cc13_61363152',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bbd8ec3dab2b16a44a95ce199d14c8d7d8a9ff1d' => 
    array (
      0 => '/project/php7/program/LGFramework2.1/site/backend/action_templates/staff/role_save.htm',
      1 => 1559518325,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5cf45cbc92cc13_61363152 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
if (!$_smarty_tpl->tpl_vars['is_layer']->value) {?>
<div class="x-nav">
          <span class="layui-breadcrumb" style="visibility: visible;">
            <a href="">首页</a><span lay-separator="">/</span>
            <a href="">后台管理</a><span lay-separator="">/</span>
            <a>
              <cite>用户组添加/修改</cite></a>
          </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<?php }?>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">

                    <form class="layui-form" action="" method="POST" target="tmpSubFrame">
                        <div class="layui-form-item">
                            <label class="layui-form-label">用户组名</label>
                            <div class="layui-input-block">
                                <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['groupInfo']->value['group_name'];?>
"
                                       id="group_name" name="group_name" required  lay-verify="required" placeholder="用户组名" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">是否启用</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['groupInfo']->value['is_delete']) {?>checked<?php } else {
}?> id="is_delete" name="is_delete" value="1" lay-skin="switch">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">描述</label>
                            <div class="layui-input-block">
                                <textarea name="note" placeholder="请输入内容" class="layui-textarea"><?php echo $_smarty_tpl->tpl_vars['groupInfo']->value['note'];?>
</textarea>
                            </div>
                        </div>
                        <!--
                        <div class="layui-form-item">
                            <label class="layui-form-label">是否超级用户组</label>
                            <div class="layui-input-block">
                                <input type="checkbox" id="is_super" name="is_super" lay-skin="switch">
                            </div>
                        </div>
                        -->

                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">权限分配</label>
                            <div class="layui-input-block">

                                <div id="LAY-auth-tree-index" style="border:1px solid #c2c2c2;padding: 10px;background: #f9f9f9;"></div>

                                <div class="layui-collapse" style="display: none">
                                    <div class="layui-colla-item">
                                        <h2 class="layui-colla-title">任务管理</h2>
                                        <div class="layui-colla-content layui-show">
                                            <div class="layui-row">
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="列表、排序、搜索">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="设为待提交">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="下架">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="查看操作记录">
                                                </div>

                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="查看金币领取记录">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="数据推送记录">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="任务派单">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="查看积分领取记录">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="layui-colla-item">
                                        <h2 class="layui-colla-title">客户管理</h2>
                                        <div class="layui-colla-content layui-show">

                                            <div class="layui-row">
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="列表、排序、搜索">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="添加客户">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="删除客户">
                                                </div>
                                            </div>

                                    </div>
                                    <div class="layui-colla-item">
                                        <h2 class="layui-colla-title">表单管理</h2>
                                        <div class="layui-colla-content layui-show">
                                            <div class="layui-row">
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="列表、排序、搜索">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="添加">
                                                </div>
                                                <div class="layui-col-md3">
                                                    <input type="checkbox" name="like[write]" title="删除">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="group_id" value="<?php echo $_smarty_tpl->tpl_vars['groupInfo']->value['group_id'];?>
" />
                                <input type="hidden" name="act" value="saveGroupInfo" />
                                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<iframe class="tmpFrame" id="tmpSubFrame" name="tmpSubFrame" src=""  style="display:none;"></iframe>

<?php echo '<script'; ?>
>
var index;

layui.config({
    base: '/lib/layui/extend/',
}).extend({
    authtree: 'authtree',
});

$(document).ready(function(){
    layui.use('form', function(){
        var form = layui.form;

        //监听提交
        form.on('submit(formDemo)', function(data){
            //layer.msg(JSON.stringify(data.field));
            validate();
            return true;
        });
    });

    $(function () {
        //绑定iframeonload函数
        var subIframe = document.getElementById('tmpSubFrame');
        if (subIframe.attachEvent){
            subIframe.attachEvent("onload",submitFrameComplete);
        } else {
            subIframe.onload = submitFrameComplete;
        }

    });

    //提交信息
    function submitFrameComplete(){
        var iframeObj = document.getElementById('tmpSubFrame').contentWindow;
        eval("data="+iframeObj.document.body.innerHTML);
        layer.close(index);

        if(data.type=='saveBaseinfo'){
            if(data.id>0){
                layer.msg(data.message);
                //返回列表并刷新页面
                parent.xadmin.add_tab('角色管理','/staff/role',true)

                //提交成功关闭tab
                xadmin.del_tab()

                //如果弹出层，则关闭弹出层
                window.setTimeout(function () {
                    xadmin.close();
                },1000);
            }else{
                layer.msg(data.error.error);
            }
        }else{
            if(data.error&&data.error.error){
                layer.msg(data.error.error);
            }else if(data.error&&data.error.error==undefined){
                layer.msg(data.error);
            }else{
                layer.msg('提交失败，服务端数据异常');
            }
        }
        $('button[type="submit"]').attr('disabled',false);
    }

    //验证提交基本信息
    function validateBaseInfo(){

        var groupname = checkFormParams('group_name','string','用户组名',true,layer.msg);
        if(groupname==false ) return false;

        var ifmod = checkFormParams('is_delete','int','是否删除',false,layer.msg);
        if(ifmod===false ) return false;

        return true;
    }

    function validate(){
        $('button[type="submit"]').attr('disabled',true);
        var result = validateBaseInfo();
        if(!result){
            $('button[type="submit"]').attr('disabled',false);
            return false;
        }else{
            index = layer.load(1, {shade: [0.1,'#fff']});
            return true;
        }
    }


    //==权限树==================
    layui.use(['jquery', 'authtree', 'form', 'layer'], function(){
        var authtree = layui.authtree;
        var form = layui.form;
        var layer = layui.layer;
        $.ajax({
            url:'/staff/authtrees',//'/tree.json',
            dataType: 'json',
            success: function(data){
                // 渲染时传入渲染目标ID，树形结构数据（具体结构看样例，checked表示默认选中），以及input表单的名字
                authtree.render('#LAY-auth-tree-index', data.data.trees, {
                    inputname: 'authids[]'
                    ,layfilter: 'lay-check-auth'
                    // ,autoclose: false
                    // ,autochecked: false
                    // ,openchecked: true
                    // ,openall: true
                    ,autowidth: true
                });

                // PS:使用 form.on() 会引起了事件冒泡延迟的BUG，需要 setTimeout()，并且无法监听全选/全不选
                // PS:如果开启双击展开配置，form.on()会记录两次点击事件，authtree.on()不会
                form.on('checkbox(lay-check-auth)', function(data){
                    // 注意这里：需要等待事件冒泡完成，不然获取叶子节点不准确。
                    setTimeout(function(){
                        console.log('监听 form 触发事件数据', data);
                        // 获取选中的叶子节点
                        var leaf = authtree.getLeaf('#LAY-auth-tree-index');
                        console.log('leaf', leaf);
                        // 获取最新选中
                        var lastChecked = authtree.getLastChecked('#LAY-auth-tree-index');
                        console.log('lastChecked', lastChecked);
                        // 获取最新取消
                        var lastNotChecked = authtree.getLastNotChecked('#LAY-auth-tree-index');
                        console.log('lastNotChecked', lastNotChecked);
                    }, 100);
                });
                // 使用 authtree.on() 不会有冒泡延迟
                authtree.on('change(lay-check-auth)', function(data) {
                    console.log('监听 authtree 触发事件数据', data);
                    // 获取所有节点
                    var all = authtree.getAll('#LAY-auth-tree-index');
                    console.log('all', all);
                    // 获取所有已选中节点
                    var checked = authtree.getChecked('#LAY-auth-tree-index');
                    console.log('checked', checked);
                    // 获取所有未选中节点
                    var notchecked = authtree.getNotChecked('#LAY-auth-tree-index');
                    console.log('notchecked', notchecked);
                    // 获取选中的叶子节点
                    var leaf = authtree.getLeaf('#LAY-auth-tree-index');
                    console.log('leaf', leaf);
                    // 获取最新选中
                    var lastChecked = authtree.getLastChecked('#LAY-auth-tree-index');
                    console.log('lastChecked', lastChecked);
                    // 获取最新取消
                    var lastNotChecked = authtree.getLastNotChecked('#LAY-auth-tree-index');
                    console.log('lastNotChecked', lastNotChecked);
                });
                authtree.on('deptChange(lay-check-auth)', function(data) {
                    console.log('监听到显示层数改变',data);
                });
            },
            error: function(xml, errstr, err) {
                layer.alert(errstr+'，获取样例数据失败，请检查是否部署在本地服务器中！');
            }
        });
    });


});
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:common/footer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
