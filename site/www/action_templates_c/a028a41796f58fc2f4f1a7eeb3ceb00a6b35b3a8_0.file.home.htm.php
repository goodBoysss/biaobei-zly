<?php
/* Smarty version 3.1.33, created on 2022-10-21 20:41:07
  from '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/www/action_templates/home/home.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_635293638fe721_94237376',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a028a41796f58fc2f4f1a7eeb3ceb00a6b35b3a8' => 
    array (
      0 => '/System/Volumes/Data/project/Work_lyx/LYXPHPUrlsServer/site/www/action_templates/home/home.htm',
      1 => 1593325781,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_635293638fe721_94237376 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>短网址</title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->

    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>

    <meta name="msapplication-TileColor" content="#0e90d2">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<div class="header">

    <div class="am-g">
        <img src="/images/logo_280x62.png">
    </div>
    <hr>
</div>

<div class="main-con" >
    <div class="layui-form" style="min-width: 500px;width:40%;margin: 30px auto;min-height:540px; vertical-align: middle;">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">缩短网址</li>
                <li>还原网址</li>
                <li>批量生成</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0px">

                <!--缩短网址-->
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <input type="text" id="url" name="url" required  lay-verify="required"
                               style="display: inline-block;width: 75%;"
                               placeholder="请输入长网址" autocomplete="off" class="layui-input">

                        <button type="button" class="layui-btn  layui-btn-normal" id="shorten"
                                style="margin: -4px 0px 0px -5px;width: 25%;border-radius: 0px;">
                            缩短网址
                        </button>
                    </div>

                    <div class="layui-form-item" id="">
                        <label class="layui-form-label" style="padding:9px 15px 9px 0;width:auto;">短网址：</label>
                        <div class="layui-input-inline" id="domainsList" style="width: calc(100% - 90px);">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" style="padding:9px 15px 9px 0;width:auto;">有效期：</label>
                        <div class="layui-input-inline" style="width: 90px">
                            <select name="expire" lay-verify="">
                                <option value="1">30天</option>
                                <option value="2">1年</option>
                                <option value="3">长期</option>
                            </select>
                        </div>
                    </div>




                    <div style="text-align:center;width:100%;margin-top: 30px; display: none;">
                        <hr>
                        <div id="qrcode" style="width: 200px;height:200px;padding:10px;border: 1px solid black;margin: 20px auto 0 auto;display: inline-block;"> </div>
                        <br>
                        <span class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary"
                              style="margin-top: 20px;width: 120px;">
                            扫码预览
                        </span>
                    </div>

                </div>

                <!--还原网址-->
                <div class="layui-tab-item">
                    <input type="text" id="s_url" name="s_url" required  lay-verify="required"
                           style="display: inline-block;width: 75%;"
                           placeholder="请输入短网址" autocomplete="off" class="layui-input">

                    <button id="expand" type="button" class="layui-btn  layui-btn-normal"
                            style="margin: -4px 0px 0px -5px;width: 25%;border-radius: 0px;">
                        还原网址
                    </button>
                </div>

                <!--批量缩短网址-->
                <div class="layui-tab-item">
                    <div class="layui-input-block" style="margin-left: 0px">
                        <textarea id="raw_url" name="raw_url" rows="8" placeholder="每行一个长网址，一次最多支持生成100条" class="layui-textarea"></textarea>
                    </div>
                    <div class="layui-input-block" style="margin:15px 0px 0px 0px;">
                        <button id="batchShorten" type="button" class="layui-btn  layui-btn-normal" id="shortenBatch"
                                style="border-radius: 0px;">
                            批量生成
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="footer">
    <span>©2020 杭州利伊享数据科技有限公司</span>  |  <span>浙ICP备15010709号-4</span>  |   <span>联系我们：400-028-2801</span>  |<span> 技术支持：杭州利伊享数据科技有限公司</span>
</div>


<div id="batchUrlLayer" style="display: none">
    <div style="margin: 10px;">
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>原始地址</th>
                <th>短网址</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?php echo '<script'; ?>
 src="/js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/lib/layui/layui.all.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/js/utils.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/js/jquery.qrcode.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/req.js?00002"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use(['element'], function(){
        var element = layui.element;
        //…
    });
<?php echo '</script'; ?>
>

</body>
</html><?php }
}
