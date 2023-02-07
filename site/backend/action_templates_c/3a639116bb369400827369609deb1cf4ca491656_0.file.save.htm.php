<?php
/* Smarty version 3.1.33, created on 2020-06-15 10:05:29
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/blackip/save.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee6d769a37e29_05890627',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a639116bb369400827369609deb1cf4ca491656' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/blackip/save.htm',
      1 => 1592186722,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ee6d769a37e29_05890627 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
if (!isset($_smarty_tpl->tpl_vars['is_layer']->value)) {?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>配置管理</cite></a><span lay-separator="">/</span>
        <a><cite>添加黑名单</cite></a>
    </span>
</div>
<?php }?>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form id="frmMain" class="layui-form" action="" method="post">

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span class="layui-badge-dot"></span> IP地址</label>
                            <div class="layui-input-block">
                                <input type="text" id="ip" name="ip"   value="<?php if (isset($_smarty_tpl->tpl_vars['blackipOne']->value['ip'])) {
echo $_smarty_tpl->tpl_vars['blackipOne']->value['ip'];
}?>"
                                       required maxlength="64" lay-verify="required" placeholder="请输入IP地址" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['blackipOne']->value['state'] == 1) {?>checked<?php }?> id="state" name="state" value="1" lay-skin="switch">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['blackipOne']->value['id'];?>
" />
                                <input type="hidden" name="act" value="saveBlackipInfo" />
                                <button type="button" class="layui-btn btn-submit"><i class="fa fa-save"></i> 保存</button>
                                <button type="reset" class="layui-btn layui-btn-primary"><i class="fa fa-refresh"></i> 重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
>
    var isEdit = <?php if ($_smarty_tpl->tpl_vars['blackipOne']->value['id'] > 0) {?>true<?php } else { ?>false<?php }?>; //是否是编辑状态
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>

    $(document).ready(function(){
        initForm();

        bindEvent();
    });

    function initForm() {

        layui.use(['form'], function() {
            //var form = layui.form;
            //var _autocomplete = layui.autocomplete;

        });
    }

    function bindEvent(){
        //监听提交
        $('.btn-submit').on('click', function () {

            if(!validate()) return false;

            xbLayAjax.submitForm({
                beforeSubmit: function () {
                    xbLayUi.loading('数据处理中...');
                },
                success: function (data, status, xhr, $form) {
                    xbLayUi.close();
                    if (data.error != '') {
                        xbLayUi.alert(data.error.error, 'error');
                    } else {
                        parent.listDatas.doSearch();
                        parent.xbLayUi.msg(data.message);
                        xbLayUi.close('self');
                    }
                }
            });
        });


        $('.btn-close').on('click', function () {
            xbLayUi.close('self');
        });
    }


    //验证提交基本信息
    function validateBaseInfo(){

        var ip = checkFormParams('ip','string','ip',true,layer.msg);
        if(ip===false ) {
            layer.msg('请输入IP地址');
            return false;
        }

        return true;
    }

    function validate(){
        $('button[type="submit"]').attr('disabled',true);
        var result = validateBaseInfo();
        if(!result){
            $('button[type="submit"]').attr('disabled',false);
            return false;
        }else{
            //index = layer.load(1, {shade: [0.1,'#fff']});
            return true;
        }
    }

<?php echo '</script'; ?>
>



<?php $_smarty_tpl->_subTemplateRender('file:common/footer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
