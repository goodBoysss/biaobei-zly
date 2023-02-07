<?php
/* Smarty version 3.1.33, created on 2020-06-15 16:54:16
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/staff/auth_save.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee7373831afd4_62418318',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '375cd92d1895840da8be0bb64f9bfd6d3c5e2b26' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/staff/auth_save.htm',
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
function content_5ee7373831afd4_62418318 (Smarty_Internal_Template $_smarty_tpl) {
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
                            <label class="layui-form-label">权限名称</label>
                            <div class="layui-input-block">
                                <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['menusInfo']->value['right_name'];?>
"
                                       id="right_name" name="right_name" required  lay-verify="required" placeholder="权限名称" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">权限状态</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['groupInfo']->value['state']) {?>checked<?php } else { ?>checked<?php }?> id="state" name="state" value="1" lay-skin="switch">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">备注</label>
                            <div class="layui-input-block">
                                <textarea name="note" placeholder="请输入内容" class="layui-textarea"><?php echo $_smarty_tpl->tpl_vars['menusInfo']->value['note'];?>
</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">地址</label>
                            <div class="layui-input-block">
                                <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['menusInfo']->value['url'];?>
"
                                       id="url" name="url"  placeholder="地址" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">排序值</label>
                            <div class="layui-input-inline">
                                <input type="number" value="<?php echo $_smarty_tpl->tpl_vars['menusInfo']->value['sort_num'];?>
"
                                       id="sort_num" name="sort_num"  placeholder="排序值" autocomplete="off" class="layui-input">
                            </div>
                        </div>



                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="sr_menu_id" value="<?php echo $_smarty_tpl->tpl_vars['menusInfo']->value['sr_menu_id'];?>
" />
                                <input type="hidden" name="level" value="<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
" />
                                <input type="hidden" name="parent_id" value="<?php echo $_smarty_tpl->tpl_vars['parent_id']->value;?>
" />
                                <input type="hidden" name="act" value="saveRightMenusInfo" />
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
                    parent.reload();
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

        var rightname = checkFormParams('right_name','string','权限名称',true,layer.msg);
        if(rightname==false ) return false;

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


});
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:common/footer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
