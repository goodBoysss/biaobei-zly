<?php
/* Smarty version 3.1.33, created on 2020-06-10 14:40:00
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/urls/short_addr_save.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee08040da1b21_03618509',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c1915785d9c11e23198f7aa17f78787a38a409c' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/urls/short_addr_save.htm',
      1 => 1591770868,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ee08040da1b21_03618509 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
if (!isset($_smarty_tpl->tpl_vars['is_layer']->value)) {?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>短域名列表</cite></a><span lay-separator="">/</span>
        <a><cite>添加短域名</cite></a>
    </span>
</div>
<?php }?>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form id="frmMain" class="layui-form" action="" method="post">
                        <div class="layui-form-item company-contain-form" >
                            <label class="layui-form-label"><span class="layui-badge-dot"></span> 关联企业</label>
                            <div class="layui-input-block">
                                <select id="company_id" name="company_id" lay-verify="required" placeholder="请选择企业" autocomplete="off" lay-search>
                                    <option value="0" selected <?php if ($_smarty_tpl->tpl_vars['shortAddrInfo']->value['company_id'] == 0) {?>selected<?php }?>>公共</option>
                                    <option value="7235" <?php if ($_smarty_tpl->tpl_vars['shortAddrInfo']->value['company_id'] == 7235) {?>selected<?php }?>>杭州日思夜享数据科技有限公司</option>
                                    <option value="7236" <?php if ($_smarty_tpl->tpl_vars['shortAddrInfo']->value['company_id'] == 7236) {?>selected<?php }?>>杭州利伊享数据科技有限公司</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span class="layui-badge-dot"></span> 短域名地址</label>
                            <div class="layui-input-block">
                                <input type="text" id="short_url" name="short_url" <?php if ($_smarty_tpl->tpl_vars['shortAddrInfo']->value['id'] > 0) {?>readonly<?php }?>  value="<?php if (isset($_smarty_tpl->tpl_vars['shortAddrInfo']->value['short_url'])) {
echo $_smarty_tpl->tpl_vars['shortAddrInfo']->value['short_url'];
}?>"
                                       required maxlength="64" lay-verify="required" placeholder="请输入短域名地址" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['shortAddrInfo']->value['status'] == 1) {?>checked<?php }?> id="status" name="status" value="1" lay-skin="switch">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['shortAddrInfo']->value['id'];?>
" />
                                <input type="hidden" name="act" value="saveShortAddrInfo" />
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
    var isEdit = <?php if ($_smarty_tpl->tpl_vars['shortAddrInfo']->value['id'] > 0) {?>true<?php } else { ?>false<?php }?>; //是否是编辑状态
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

        var company_id = checkFormParams('company_id','int','企业ID',true,layer.msg);
        if(company_id===false ) {
            layer.msg('请选择企业');
            return false;
        }

        var short_url = checkFormParams('short_url','url','短域名地址',true,layer.msg);
        if(short_url==false ) return false;


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
