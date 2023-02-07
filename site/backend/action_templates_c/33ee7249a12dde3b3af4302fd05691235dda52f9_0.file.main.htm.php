<?php
/* Smarty version 3.1.33, created on 2020-06-10 13:56:36
  from '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/index/main.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ee0761460ead2_59639057',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '33ee7249a12dde3b3af4302fd05691235dda52f9' => 
    array (
      0 => '/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/index/main.htm',
      1 => 1590051467,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.htm' => 1,
    'file:common/footer.htm' => 1,
  ),
),false)) {
function content_5ee0761460ead2_59639057 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:common/header.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <blockquote class="layui-elem-quote">欢迎管理员：
                        <span class="x-red"><?php if ($_SESSION['adm_user']['username']) {
echo $_SESSION['adm_user']['truename'];
} else { ?>Anonymous<?php }?></span>！当前时间:<?php echo date('Y-m-d H:i:s');?>

                    </blockquote>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">数据统计</div>
                <div class="layui-card-body ">
                    <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>文章数</h3>
                                <p>
                                    <cite>66</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>会员数</h3>
                                <p>
                                    <cite>12</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>回复数</h3>
                                <p>
                                    <cite>99</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>商品数</h3>
                                <p>
                                    <cite>67</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>文章数</h3>
                                <p>
                                    <cite>67</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6 ">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>文章数</h3>
                                <p>
                                    <cite>6766</cite></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">下载
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                <div class="layui-card-body  ">
                    <p class="layuiadmin-big-font">33,555</p>
                    <p>新下载
                        <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">下载
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                <div class="layui-card-body ">
                    <p class="layuiadmin-big-font">33,555</p>
                    <p>新下载
                        <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">下载
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                <div class="layui-card-body ">
                    <p class="layuiadmin-big-font">33,555</p>
                    <p>新下载
                        <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">下载
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                <div class="layui-card-body ">
                    <p class="layuiadmin-big-font">33,555</p>
                    <p>新下载
                        <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">系统信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <tr>
                            <th>系统版本</th>
                            <td>1.0.20190515</td></tr>
                        <tr>
                            <th>服务器地址</th>
                            <td>http://bg.lg2.lh</td></tr>
                        <tr>
                            <th>操作系统</th>
                            <td><?php echo php_uname('s');?>
</td></tr>
                        <tr>
                            <th>运行环境</th>
                            <td><?php echo $_SERVER['SERVER_SOFTWARE'];?>
</td></tr>
                        <tr>
                            <th>PHP版本</th>
                            <td><?php echo @constant('PHP_VERSION');?>
</td></tr>
                        <tr>
                            <th>PHP运行方式</th>
                            <td><?php echo php_sapi_name();?>
</td></tr>
                        <tr>
                            <th>MYSQL版本</th>
                            <td>-</td></tr>
                        <tr>
                            <th>LGFrameWork</th>
                            <td>2.0.1</td></tr>
                        <tr>
                            <th>上传附件限制</th>
                            <td><?php echo ini_get('upload_max_filesize');?>
</td></tr>
                        <tr>
                            <th>执行时间限制</th>
                            <td><?php echo ini_get('max_execution_time');?>
s</td></tr>
                        <tr>
                            <th>剩余空间</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['diskFreeSpace']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">开发团队</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <tr>
                            <th>版权所有</th>
                            <td>&copy; Gaorq.LGFramework2 &nbsp;  &nbsp;授权：杭州利伊享数据科技有限公司/杭州日思夜享数据科技有限公司</tr>
                        </tr>
                        <tr>
                            <th>开发者</th>
                            <td>gaorq <a href="mailto:goen88@163.com">&lt;goen88@163.com&gt;</a> </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <style id="welcome_style"></style>
        <div class="layui-col-md12">
            <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,本系统UI基于x-admin。</blockquote></div>
    </div>
</div>
</div>
<?php $_smarty_tpl->_subTemplateRender('file:common/footer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
