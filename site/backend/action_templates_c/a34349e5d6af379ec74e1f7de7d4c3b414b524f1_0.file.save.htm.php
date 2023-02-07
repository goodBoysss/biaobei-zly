<?php
/* Smarty version 3.1.33, created on 2020-06-16 09:02:28
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/apiAuthorize/save.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee81a24a24966_09552071',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a34349e5d6af379ec74e1f7de7d4c3b414b524f1' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/apiAuthorize/save.htm',
      1 => 1592269340,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ee81a24a24966_09552071 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
if (!isset($_smarty_tpl->tpl_vars['is_layer']->value)) {?>
<div class="x-nav">
    <span class="layui-breadcrumb" style="visibility: visible;">
        <a><cite>首页</cite></a><span lay-separator="">/</span>
        <a><cite>配置管理</cite></a><span lay-separator="">/</span>
        <a><cite>添加API授权</cite></a>
    </span>
</div>
<?php }?>


<style>
    .api-authorize{
        padding: 10px;
        margin: 0px;
        border: 1px solid #eeeeee;
        background: #f0f0f0;
    }
    .api-authorize li{
        margin: 5px 0px;
    }
    .api-authorize li input{
        width: 120px;
        display: inline-block;
        border: 1px solid #cccccc;
        margin-left: -5px;
        margin-top: -2px;
    }
    .api-authorize li span{
        display: inline-block;
        padding: 0px 10px;
        height: 28px;
        line-height: 28px;
        border: 1px solid #cccccc;
        background: #ffffff;
    }
    .api-authorize li span.note{
        border: none;
        height: 30px;
        line-height: 30px;
        color: #999999;
    }
</style>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form id="frmMain" class="layui-form" action="" method="post">

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span class="layui-badge-dot"></span>授权名称</label>
                            <div class="layui-input-block">
                                <input type="text" id="name" name="name"   value="<?php if (isset($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['name'])) {
echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['name'];
}?>"
                                       required maxlength="64" lay-verify="required" placeholder="请输入授权名称" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item company-contain-form" >
                            <label class="layui-form-label"><span class="layui-badge-dot"></span> 关联企业</label>
                            <div class="layui-input-block">
                                <select id="company_id" name="company_id" lay-verify="required" placeholder="请选择企业" autocomplete="off" lay-search>
                                    <option value="0" selected <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['company_id'] == 0) {?>selected<?php }?>>公共</option>
                                    <option value="7235" <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['company_id'] == 7235) {?>selected<?php }?>>杭州日思夜享数据科技有限公司</option>
                                    <option value="7236" <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['company_id'] == 7236) {?>selected<?php }?>>杭州利伊享数据科技有限公司</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span class="layui-badge-dot"></span>权限配置</label>
                            <div class="layui-input-block">
                                <ul class="api-authorize">
                                    <li>
                                        <span>每分钟最大请求数：</span>
                                        <input type="text" id="rate_minute" name="rate_minute"   value="<?php echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['rate_minute'];?>
" required   autocomplete="off" class="layui-input" />
                                        <span class="note"> * 等于0表示不限制</span>
                                    </li>
                                    <li>
                                        <span>每小时最大请求数：</span>
                                        <input type="text" id="rate_hour" name="rate_hour"   value="<?php echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['rate_hour'];?>
" required   autocomplete="off" class="layui-input" />
                                        <span class="note"> * 等于0表示不限制</span>
                                    </li>
                                    <li>
                                        <span>每一天最大请求数：</span>
                                        <input type="text" id="rate_day" name="rate_day"   value="<?php echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['rate_day'];?>
" required   autocomplete="off" class="layui-input" />
                                        <span class="note"> * 等于0表示不限制</span>
                                    </li>
                                    <li>
                                        <span>每个月最大请求数：</span>
                                        <input type="text" id="rate_month" name="rate_month"   value="<?php echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['rate_month'];?>
" required   autocomplete="off" class="layui-input" />
                                        <span class="note"> * 等于0表示不限制</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">访问类型</label>
                            <div class="layui-input-block">
                                <input type="radio" name="access_type" value="1" lay-filter="access_type" title="公开" <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['access_type'] == 1) {?>checked<?php }?>>
                                <input type="radio" name="access_type" value="2" lay-filter="access_type" title="白名单" <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['access_type'] == 2) {?>checked<?php }?>>
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text" style="display: <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['access_type'] == 2) {?>block<?php } else { ?>none<?php }?>" id="whiteListCon">
                            <label class="layui-form-label"><span class="layui-badge-dot"></span>白名单</label>
                            <div class="layui-input-block">
                                <textarea name="white_list" placeholder="请输入白名单IP，多个用逗号（,）分割" class="layui-textarea"><?php echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['white_list'];?>
</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['status'] == 1) {?>checked<?php }?> id="status" name="status" value="1" lay-skin="switch" lay-text="开启|关闭" />
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"></span>有效期</label>
                            <div class="layui-input-inline">
                                <input class="layui-input" autocomplete="off" placeholder="有效期" name="expire" id="expire" lay-key="1"
                                       value="<?php if (isset($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['expire']) && $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['expire'] != '0000-00-00 00:00:00') {
echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['expire'];
}?>">

                            </div>
                            <div class="layui-form-mid layui-word-aux">* 等于空表示不限制</div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['apiauthorizeOne']->value['id'];?>
" />
                                <input type="hidden" name="act" value="saveBaseInfo" />
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
    var isEdit = <?php if ($_smarty_tpl->tpl_vars['apiauthorizeOne']->value['id'] > 0) {?>true<?php } else { ?>false<?php }?>; //是否是编辑状态
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>

    $(document).ready(function(){
        initForm();

        bindEvent();
    });

    function initForm() {
        layui.use(['laydate','form'], function() {
            form = layui.form;
            laydate = layui.laydate

            form.on('radio(access_type)', function(data){
                swtichAccessType(data)
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#expire' //指定元素
                ,type: 'datetime'
            });
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

    //切换访问类型
    function swtichAccessType(data) {
        if(data.value==2){
            $("#whiteListCon").show()
        }else{
            $("#whiteListCon").hide()
        }
    }

    //验证提交基本信息
    function validateBaseInfo(){

        var name = checkFormParams('name','string','name',true,layer.msg);
        if(name===false ) {
            layer.msg('请输入授权名称');
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
