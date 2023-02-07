/**
 *
 * 项目中使用layui组件 获取数据
 */

var xbLayUi = {};
var xbLayAjax = {};

xbLayUi.layerIndex = 0;

/**
 * 使用layui 根据企业名称模糊获取相关企业列表
 * 企业自动检索
 *
 * 引用前端html代码
 *
 <div class="layui-input-inline" style="width: 250px;margin-right: 0;">
 <input type="hidden" class="form-filter" id="enterprise_id" name="enterprise_id" value="0" />
 <input type="text" id="enterprise" layui-autocomplete class="layui-input" />
 </div>
 *
 * @author liuxz<liuxz@51lick>
 * @date 2019-06-11
 *
 */
xbLayUi.getSearchForSelectEnterprise = function () {

    layui.use(['autocomplete'], function () {
        var form = layui.form;
        var autocomplete = layui.autocomplete;

        autocomplete.render({
            elem: $('#enterprise')[0],
            url: '/common/searchForSelect',
            cache: false,
            template_val: '{{d.name}}',
            template_txt: '{{d.name}}',
            onselect: function (resp) {
                $('input[name=enterprise_id]').val(resp.id);
            }
        });

        // 任意修改搜索企业名称重置企业ID为0
        $('#enterprise').on('change', function () {
            $('input[name=enterprise_id]').val(0);
        });
    });

};


/**
 * 使用layui 时间区间选择
 *
 * 引用前端html代码
 *
 <div class="layui-inline">
 <label class="layui-form-label" style="width:100px;">添加时间</label>
 <div class="layui-input-inline" style="width: 250px;margin-right: 0;">
 <input type="text" class="layui-input" id="date_added">
 <input type="hidden" name="date_added_start" id="date_added_start">
 <input type="hidden" name="date_added_end" id="date_added_end">
 </div>
 </div>

 * @author liuxz<liuxz@51lick>
 * @date 2019-06-11
 * id input时间选择元素
 * id+'_start' 表示起始时间
 * id+'_end' 表示起始时间
 *
 */
xbLayUi.getDateRange = function (id = 'date_added') {

    layui.use('laydate', function () {
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#' + id, //指定元素
            range: true,
            theme: 'grid',
            format: 'yyyy-MM-dd',
            done: function (value, date, endDate) {
                //value  得到日期生成的值，如：2017-08-18 如果是(range: true) 则返回 2019-06-07 - 2019-07-30
                //date 日期时间对象 {year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                //endDate  得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上
                var startDate1 = '';
                var endDate1 = '';
                if (value) {
                    var value_arr = value.split(" - ");
                    startDate1 = value_arr[0];
                    endDate1 = value_arr[1];
                }
                $('#' + id + '_start').val(startDate1);
                $('#' + id + '_end').val(endDate1);
            }
        });
    });
}


/**
 *  初始化 froala editor编译器
 *  container 内容
 *
 *  type 显示的按钮
 *  option_params 额外属性
 */
xbLayUi.initFroalaEditor = function (obj) {
    var type;

    if (obj == undefined || obj.container == undefined) {
        var container = 'textarea.froala-editor'
    }
    if (obj == undefined || obj.type == undefined) {
        type = 'sm'
    } else {
        type = obj.type;
    }

    var toolbarButtons = [];

    if (type == 'big') {
        toolbarButtons = ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
            '|', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineStyle',
            '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote',
            '-', 'insertLink', 'insertImage', 'embedly', 'insertTable',
            '|', 'insertHR', 'selectAll', 'clearFormatting',
            '|', 'spellChecker', 'html',
            '|', 'undo', 'redo'];
    } else if (type == 'md') {
        toolbarButtons = ['fullscreen', 'bold', 'italic', 'underline', 'fontFamily', 'fontSize',
            'insertLink', 'insertImage', 'insertTable', 'undo', 'redo'];
    } else if (type == 'sm') {
        toolbarButtons = ['undo', 'redo', '|', 'bold', 'italic', 'underline'];
    } else if(type == 'builder') {
        toolbarButtons = ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',
            'subscript', 'superscript', '|', 'fontFamily', 'fontSize',
            'color', 'inlineClass', 'inlineStyle', 'paragraphStyle',
            'lineHeight', '|', 'paragraphFormat', 'align', 'formatOL',
            'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink',
            'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable',
            '|', 'emoticons', 'fontAwesome', 'specialCharacters', 'insertHR',
            'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker',
            'help', 'html', '|', 'undo', 'redo'];
    }else{
        toolbarButtons = ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',
            'subscript', 'superscript', '|', 'fontFamily', 'fontSize',
            'color', 'inlineClass', 'inlineStyle', 'paragraphStyle',
            'lineHeight', '|', 'paragraphFormat', 'align', 'formatOL',
            'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink',
            'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable',
            '|', 'emoticons', 'fontAwesome', 'specialCharacters', 'insertHR',
            'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker',
            'help', 'html', '|', 'undo', 'redo'];
    }

    var options = {
        language: 'zh_cn',
        DEFAULTS: {
            key: "MCHCPd1XQVZFSHSd1C=="
        },
        toolbarSticky: false,
        toolbarButtons: toolbarButtons,
        heightMin: 100,
        quickInsertButtons: [],
        tableResizerOffset: 10,
        tableResizingLimit: 50

    }


    if (obj != undefined && obj.option_params != undefined) {

        options = $.extend(options, obj.option_params);
    }

    return new FroalaEditor(container, options);


}


/***
 * ajax提交数据 confirm
 * * @param  obj 提交的熟悉
 * @obj text 提示语
 * @obj url  提交地址
 * @obj params 提交数据 是个对象
 * @obj okCallback 提交成功后回调
 * @obj errorCallback 提交错误后回调
 */
xbLayAjax.confirm = function (obj) {

    if (obj.url == '' || obj.url == 'undefined') {

        return false;
    }

    if (obj.params == '' || obj.params == 'undefined') {
        obj.params = {};
    }

    layer.confirm(obj.text, function (index) {
        _layerIndex = layer.load();
        $.post(obj.url, obj.params, function (data) {
            layer.close(_layerIndex);
            if (data.status != 0) {
                //返回的错误
                layer.msg(data.error, {icon: 2});

                if (obj.errorCallback != undefined) {

                    if (typeof obj.okCallback == 'function') {
                        obj.okCallback(data);
                    }
                }

            } else {
                //返回成功
                layer.msg(data.text, {icon: 1});
                if (obj.okCallback != undefined) {

                    if (typeof obj.okCallback == 'function') {
                        obj.okCallback(data);
                    }
                }
            }
        }, 'json');

    });
};


/***
 * ajaxSubmit表单提交
 * * @param  obj 提交的属性
 * @obj ele 表单对象选择器
 * @obj success 提交成功回调方法
 * @obj beforeSubmit 表单提交前回调方法
 * @obj beforeSerialize 表单参数序列化前回调方法
 */
xbLayAjax.submitForm = function (obj) {
    var ele = '#frmMain';
    var options = {};
    if (obj.ele != '' && obj.ele != undefined) {
        ele = obj.ele;
    }
    if (obj.beforeSubmit != '' && obj.beforeSubmit != undefined && typeof obj.beforeSubmit == 'function') {
        options['beforeSubmit'] = function () {
            obj.beforeSubmit();
        }
    }
    if (obj.beforeSerialize != '' && obj.beforeSerialize != undefined && typeof obj.beforeSerialize == 'function') {
        options['beforeSerialize'] = function () {
            obj.beforeSerialize();
        }
    }
    if (obj.success != '' && obj.success != undefined && typeof obj.success == 'function') {
        options['success'] = function (data, status, xhr, $form) {
            try {
                if (!$.isPlainObject(data)) data = JSON.parse(data); // 如果返回的是json字符串则转换成json对象
            } catch (ex) {
                data = {status: 10022, error: '未知错误', data: []};
            }
            obj.success(data, status, xhr, $form);
        }
    }

    jQuery(ele).ajaxSubmit(options);
};

/**
 * loading加载效果
 * @param msg 显示内容
 * @returns {*}
 */
xbLayUi.loading = function (msg) {
    var _msg = '加载中...';
    if (msg != undefined) {
        _msg = msg;
    }
    xbLayUi.layerIndex = layer.msg(_msg, {icon: 16, time: 0, shade: [0.5, '#000', true]});
    return xbLayUi.layerIndex;
};

/**
 * toast弹框
 * @param msg 弹框内容
 * @param icon 显示图标（info、success、error、question）
 * @returns {*}
 */
xbLayUi.msg = function (msg, icon) {
    var _msg = '未知错误';
    var _icon = 1;
    if (msg != undefined) {
        _msg = msg;
    }
    if (icon != undefined) {
        switch (icon) {
            case 'info':
                _icon = 0;
                break;
            case 'error':
                _icon = 2;
                break;
            case 'question':
                _icon = 3;
                break;
            default:
                _icon = 1;
                break;
        }
    }
    xbLayUi.layerIndex = layer.msg(_msg, {icon: _icon});
    return xbLayUi.layerIndex;
};

/**
 * 打开窗口
 * @param title 窗口标题
 * @param url 窗口内容
 * @param options 可选项（其中width、height传数字类型小于1则用屏幕宽度或高度相乘，大于等于1则用屏幕高度或宽度相减，如果是字符串类型则直接使用字符串赋值）
 */
xbLayUi.open = function (title, url, options) {
    var _options = {
        type: 2,
        area: [$(window).width() * 0.9 + 'px', ($(window).height() - 50) + 'px'],
        fix: false, //不固定
        maxmin: true,
        shadeClose: true,
        shade: 0.4
    };
    if (title != undefined) {
        _options.title = title;
    } else {
        _options.title = '新窗口';
    }
    if (url != undefined) {
        _options.content = url;
    }
    if (options != undefined && options.width != undefined) {
        if (typeof options.width == 'number') {
            if (options.width < 1) {
                _options.area[0] = $(window).width() * options.width + 'px';
            } else {
                _options.area[0] = $(window).width() - options.width + 'px';
            }
        } else if (typeof options.width == 'string') {
            _options.area[0] = options.width;
        }
    }
    if (options != undefined && options.height != undefined) {
        if (typeof options.height == 'number') {
            if (options.height < 1) {
                _options.area[1] = $(window).height() * options.height + 'px';
            } else {
                _options.area[1] = $(window).height() - options.height + 'px';
            }
        } else if (typeof options.height == 'string') {
            _options.area[1] = options.height;
        }
    }
    if (options != undefined && options.type != undefined) _options.type = options.type;
    if (options != undefined && options.fix != undefined) _options.fix = options.fix;
    if (options != undefined && options.maxmin != undefined) _options.maxmin = options.maxmin;
    if (options != undefined && options.shadeClose != undefined) _options.shadeClose = options.shadeClose;
    if (options != undefined && options.shade != undefined) _options.shade = options.shade;
    xbLayUi.layerIndex = layer.open(_options);
    if (options != undefined && options.full != undefined && options.full == true) layer.full(xbLayUi.layerIndex);
    return xbLayUi.layerIndex;
};

/**
 * alert弹层
 * @param msg 显示内容
 * @param options
 */
xbLayUi.alert = function (msg, options) {
    var _options = {
        content: msg,
        btn: ['确定']
    };
    if (options != undefined && options.btnText != undefined) {
        _options.btn[0] = options.btnText;
    }
    if (options != undefined && options.cancel != undefined && typeof options.cancel == 'function') { // 弹窗右上角取消按钮触发事件
        _options.cancel = function () {
            options.cancel();
        }
    }
    if (options != undefined && options.btnEvent != undefined && typeof options.btnEvent == 'function') {
        _options.yes = function () {
            options.btnEvent();
        }
    }
    xbLayUi.layerIndex = layer.open(_options);
    return xbLayUi.layerIndex;
};

xbLayUi.confirm = function(msg, options){
    var _options = {
        btn: ['确定', '取消'],
    };
    if (options != undefined && options.btnText != undefined) {
        _options.btn[0] = options.btnText;
    }
    if (options != undefined && options.btn2Text != undefined) {
        _options.btn[1] = options.btn2Text;
    }
    if (options != undefined && options.yes != undefined && typeof options.yes == 'function') { // 按钮一回调
        _options.yes = function () {
            options.yes();
        }
    }
    if (options != undefined && options.btn2 != undefined && typeof options.btn2 == 'function') { // 按钮二回调
        _options.btn2 = function () {
            options.btn2();
        }
    }
    xbLayUi.layerIndex = layer.confirm(msg, _options);
    return xbLayUi.layerIndex;
}

/**
 * 关闭弹层
 * @param index
 */
xbLayUi.close = function (index) {
    if (index != undefined) {
        if (index == 'all') layer.closeAll();
        else if (index == 'self') parent.xbLayUi.close(parent.layer.getFrameIndex(window.name));
        else layer.close(index);
    } else {
        layer.close(xbLayUi.layerIndex);
    }
};


/**
 * 时间区块的
 * @param _maxDate
 */
xbLayUi.initRangeDate=function(_maxDate){
    //初始化时间区块
    layui.use(['laydate'], function () {
        var laydate = layui.laydate;

        var _st = laydate.render({
            elem: '#st'
            , max: _maxDate
            , done: function (value, date, endDate) {

            }
        });

        var _et = laydate.render({
            elem: '#et'
            , max: _maxDate
            , done: function (value, date, endDate) {

            }
        });
    });
};
