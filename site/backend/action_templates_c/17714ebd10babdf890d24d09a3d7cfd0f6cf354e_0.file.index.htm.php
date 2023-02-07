<?php
/* Smarty version 3.1.33, created on 2023-02-06 18:21:50
  from '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/index/index.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63e0d4be49b6d4_39386516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '17714ebd10babdf890d24d09a3d7cfd0f6cf354e' => 
    array (
      0 => '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/backend/action_templates/index/index.htm',
      1 => 1592788402,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63e0d4be49b6d4_39386516 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>后台登录-小宝短网址管理后台V1.0</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/xadmin.css?t=201905070002">
    <link rel="stylesheet" href="/css/theme4.css">
    <?php echo '<script'; ?>
 src="/lib/layui/layui.js" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="/js/xadmin.js?dfdfdfddd"><?php echo '</script'; ?>
>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <?php echo '<script'; ?>
 src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->
    <?php echo '<script'; ?>
>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    <?php echo '</script'; ?>
>
</head>
<body class="index">
<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a href="/index">小宝短链管理后台V1.0</a></div>
    <div class="left_open">
        <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>
    <ul class="layui-nav left fast-add" lay-filter="" style="display: none">
        <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('最大化','http://www.baidu.com','','',true)">
                        <i class="iconfont">&#xe6a2;</i>弹出最大化</a></dd>
                <dd>
                    <a onclick="xadmin.open('弹出自动宽高','http://www.baidu.com')">
                        <i class="iconfont">&#xe6a8;</i>弹出自动宽高</a></dd>
                <dd>
                    <a onclick="xadmin.open('弹出指定宽高','http://www.baidu.com',500,300)">
                        <i class="iconfont">&#xe6a8;</i>弹出指定宽高</a></dd>
                <dd>
                    <a onclick="xadmin.add_tab('在tab打开','member-list.html')">
                        <i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
                <dd>
                    <a onclick="xadmin.add_tab('在tab打开刷新','member-del.html',true)">
                        <i class="iconfont">&#xe6b8;</i>在tab打开刷新</a></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;"><?php if ($_SESSION['adm_user']['username']) {
echo $_SESSION['adm_user']['truename'];
} else { ?>Anonymous<?php }?></a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('个人信息','/staff/staffSave?is_layer=1&staff_id=<?php echo $_SESSION['adm_user']['uid'];?>
')">个人信息</a></dd>
                <dd>
                    <a href="/">退出</a></dd>
            </dl>
        </li>
        <!--<li class="layui-nav-item to-index">-->
            <!--<a href="/">前台首页</a>-->
        <!--</li>-->
    </ul>
</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="链接管理">&#xe6f7;</i>
                    <cite>链接管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('短域名管理','/urls/shortAddrs')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>短域名列表</cite>
                        </a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('短链接列表','/urls')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>短链接列表</cite>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="系统配置">&#xe6ae;</i>
                    <cite>系统配置</cite>
                    <i class="iconfont nav_right">&#xe673;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('黑名单管理','/blackip')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>黑名单管理</cite>
                        </a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('API授权管理','/apiAuthorize')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>API授权管理</cite>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="管理员管理">&#xe726;</i>
                    <cite>管理员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('添加管理员','/staff/staffSave')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加管理员</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('管理员列表','/staff')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite></a>
                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('添加用户组','/staff/roleSave')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加用户组</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('用户组管理','/staff/role')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>用户组管理</cite></a>
                    </li>
                    <li style="display: none">
                        <a onclick="xadmin.add_tab('权限分类','/staff/authCategory')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限分类</cite></a>
                    </li>
                    <li style="">
                        <a onclick="xadmin.add_tab('权限管理','/staff/auth')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite></a>
                    </li>
                </ul>
            </li>
            <li style="display: none">
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="第三方组件">&#xe6b4;</i>
                    <cite>layui第三方组件</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('滑块验证','https://fly.layui.com/extend/sliderVerify/')" target="">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>滑块验证</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('富文本编辑器','https://fly.layui.com/extend/layedit/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>富文本编辑器</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('eleTree 树组件','https://fly.layui.com/extend/eleTree/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>eleTree 树组件</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('图片截取','https://fly.layui.com/extend/croppers/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>图片截取</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('formSelects 4.x 多选框','https://fly.layui.com/extend/formSelects/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>formSelects 4.x 多选框</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('Magnifier 放大镜','https://fly.layui.com/extend/Magnifier/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Magnifier 放大镜</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('notice 通知控件','https://fly.layui.com/extend/notice/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>notice 通知控件</cite></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home">
                <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
        <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
            <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd></dl>
        </div>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='/index/main' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
        <div id="tab_show"></div>
    </div>
</div>
<div class="page-content-bg"></div>
<style id="theme_style"></style>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<?php echo '<script'; ?>
>//百度统计可去掉
//var _hmt = _hmt || []; (function() {
//    var hm = document.createElement("script");
//    hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
//    var s = document.getElementsByTagName("script")[0];
//    s.parentNode.insertBefore(hm, s);
//})()
<?php echo '</script'; ?>
>
</body>

</html><?php }
}
