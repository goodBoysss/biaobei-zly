/*
 *ajax获取数据列表
 *@author gaorunqiao
 */

var listDatas = {};//数据容器
listDatas.statichost = ''; //图片服务器路径
listDatas.action = 'list'; //默认请求数据标示
listDatas.showType = 'table'; //数据显示方式 ：iocn->图标，table->列表
listDatas.containerID = '#listDiv table thead:first'; //数据呈现的默认所需的容器
listDatas.container=(listDatas.containerID).split(" ")[0];
listDatas.params = [];
listDatas.page = 0; //当前页
listDatas.page_size = parseInt(GetQueryString('page_size')) > 0 ? parseInt(GetQueryString('page_size')) : 0;//每页显示数据
listDatas.pageCount = 0; //共多少页
listDatas.totalCount = 0; // 共多少条
listDatas.isSearch = 0;//是否是搜索
listDatas.orderBy = ''; //排序 exp: "item,direction"
listDatas.isTableList=1; //默认表单格式列表
listDatas.colspan = 6; //合并行数
listDatas.dataurl = ""; //请求数据url

//alert(listDatas.container);
//表格模式
listDatas.listData = function (is_page=true) {
	//合并行数
	if (jQuery(listDatas.container+' table tr th').length && jQuery(listDatas.container+' table tr th').length > 1) {
		listDatas.colspan = jQuery(listDatas.container+' table tr th').length;
	}

	var htmlData = '';
	listDatas.params = [];
	listDatas.params.push("act=" + listDatas.action);
	if (listDatas.isSearch == 1) {
		$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])').each(function () {
			if ($(this).val()) listDatas.params.push($(this).attr("name") + '=' + $(this).val());
		});
		if (typeof listDatas.search == 'function') listDatas.search();
	}
	listDatas.params.push("page=" + listDatas.page);
	listDatas.params.push("page_size=" + listDatas.page_size);
	if (listDatas.orderBy != '') listDatas.params.push('orderby=' + listDatas.orderBy);

	jQuery(listDatas.container+' table').after('<div class="layui-table-init" style="background: rgba(255, 255, 255, 0.2);"><i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop" style="opacity: 1;z-index: 1000;font-size: 30px;color: #263035;display:inline-block;"></i></div>');
	// jQuery(listDatas.containerID).siblings().remove();
	// jQuery(listDatas.containerID).after('<tr><td class="no-records" colspan="' + listDatas.colspan + '" align="center">数据加载中，请稍候⋯<img src="' + listDatas.statichost + '/images/ajax-loader.gif"</td></tr>');
	jQuery.getJSON(listDatas.dataurl, encodeURI(listDatas.params.join('&')), function (json) {

		if (json.data == null || json.data == '') {
			htmlData = '<tbody><tr><td class="no-records" style="text-align: center;" colspan="' + listDatas.colspan + '">暂无记录</td></tr></tbody>';
		} else {
			htmlData += '<tbody>';
			for (n in json.data) {
				htmlData += listDatas.addOneData(json.data[n], n);
			}
			htmlData += '</tbody>';
		}
		if(is_page){
			htmlData += listDatas.pagerCustomer(json.filter);
		}
		jQuery(listDatas.containerID).siblings().remove();
		jQuery(listDatas.containerID).after(htmlData);
		// 回调数据加载完成事件
		listDatas.loadComplete();
		// 把主选框重置为未选中状态
		$('.cb-item-main').prop('checked', false);

		jQuery(listDatas.container+' table').next('div.layui-table-init').remove();

		// 检查列筛选
		checkColumnFilter();
	});
};

//非表格模式
listDatas.listData2 = function () {
	//合并行数
	var htmlData = '';
	listDatas.params = [];
	listDatas.params.push("act=" + listDatas.action);
	listDatas.params.push("page=" + listDatas.page);
	listDatas.params.push("page_size=" + listDatas.page_size);
	if (listDatas.orderBy != '') listDatas.params.push('orderby=' + listDatas.orderBy);

	jQuery(listDatas.containerID).siblings().remove();
	jQuery(listDatas.containerID).html('<div class="no-records" colspan="' + listDatas.colspan + '" align="center">数据加载中，请稍候⋯<img src="' + listDatas.statichost + '/images/ajax-loader.gif"</div>');
	jQuery.getJSON(listDatas.dataurl, encodeURI(listDatas.params.join('&')), function (json) {
		jQuery(listDatas.containerID).empty();
		if (json.data == null || json.data == '') {
			htmlData = '<div class="no-records" colspan="' + listDatas.colspan + '">暂无记录</div>';
		} else {
			for (n in json.data) {
				htmlData += listDatas.addOneData(json.data[n], n);
			}
		}
		htmlData += listDatas.pagerCustomer(json.filter);
		jQuery(listDatas.containerID).siblings().remove();
		jQuery(listDatas.containerID).html(htmlData);
	});
};

//排序
listDatas.sortBy = function (obj, fieldName) {
	jQuery(listDatas.containerID).parent().find("tr th span").siblings().remove();
	jQuery(listDatas.containerID).parent().find("tr th span").after('<i class="glyphicon glyphicon-sort"></i>');
	jQuery(obj).siblings().remove();
	var flag = obj.getAttribute('flag');
	var sort_flag = 'asc';
	if (flag == 'asc') {
		sort_flag = 'desc';
		obj.setAttribute('flag', 'desc');
		jQuery(obj).after('<i class="glyphicon glyphicon-sort-by-attributes-alt"></i>');
	} else {
		sort_flag = 'asc';
		obj.setAttribute('flag', 'asc');
		jQuery(obj).after('<i class="glyphicon glyphicon-sort-by-attributes"></i>');
	}
	listDatas.orderBy = fieldName + "," + sort_flag;
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}

};

//数据分页
listDatas.pager = function (filter) {
	listDatas.page = filter.page;
	listDatas.page_size = filter.page_size;
	listDatas.pageCount = filter.page_count;
	listDatas.totalCount = filter.record_count;
	var htmlData = '<tfoot>';
	htmlData += '<tr><td nowrap="true" colspan="' + listDatas.colspan + '">';
	htmlData += '<div class="layui-col-md6" style="float: left;">';
	htmlData += '共 <span id="totalRecords">' + filter.record_count + '</span>条记录，';
	htmlData += '共 <span id="totalPages">' + filter.page_count + '</span>页，';
	htmlData += '每页显示 ';
	htmlData += '<select onchange="listDatas.setPerPage(this.value)" style="display:inline-table;" lay-ignore>';
	htmlData += '<option value="5"' + (filter.page_size == 5 ? ' selected' : '') + '>5</option>';
	htmlData += '<option value="10"' + (filter.page_size == 10 ? ' selected' : '') + '>10</option>';
	htmlData += '<option value="20"' + (filter.page_size == 20 ? ' selected' : '') + '>20</option>';
	htmlData += '<option value="50"' + (filter.page_size == 50 ? ' selected' : '') + '>50</option>';
	htmlData += '<option value="100"' + (filter.page_size == 100 ? ' selected' : '') + '>100</option>';
	htmlData += '</select>&nbsp;条';
	htmlData += '</div>';
	htmlData += '<div class="layui-col-md6">';
	htmlData += '<div id="turn-page" class="lay-ignore" style="float: right;">';
	// htmlData += '当前第  <span id="pageCurrent">' + filter.page + '</span> 页';

	htmlData += '<span id="page-link">';
	htmlData += '<a href="javascript:listDatas.gotoPageFirst()">首页</a>&nbsp;&nbsp;&nbsp;';
	htmlData += '<a href="javascript:listDatas.gotoPagePrev()">上一页</a>&nbsp;&nbsp;&nbsp;';

	htmlData += '<input type="text" onchange="listDatas.gotoPage(this.value)" value="' + listDatas.page + '" style="text-align: center;width:45px;height:14px;" onkeyup="value=value.replace(/[^\\d]/g,\'\')" />';
	htmlData += '&nbsp;&nbsp;<a href="javascript:listDatas.gotoPageNext()">下一页</a>';
	htmlData += '&nbsp;&nbsp;&nbsp;<a href="javascript:listDatas.gotoPageLast()">尾页</a>';
	htmlData += '</span>';
	htmlData += '</div></div>';
	htmlData += '</td></tr></tfoot>';
	return htmlData;
};

//自定义分页
listDatas.pagerCustomer = function (filter) {
	listDatas.page = filter.page;
	listDatas.page_size = filter.page_size;
	listDatas.pageCount = filter.page_count;
	listDatas.totalCount = filter.record_count;
	var htmlData = '<tfoot>';
	htmlData += '<tr><td nowrap="true" colspan="' + listDatas.colspan + '">';
	htmlData += '<div class="layui-table-page" style="height: inherit;border: none;padding: 0px;"><div id="layui-table-page1"><div class="layui-box layui-laypage layui-laypage-default">';
	htmlData += '<span class="layui-laypage-limits">';
	htmlData += '<select lay-ignore="" onchange="listDatas.setPerPage(this.value)">';
	htmlData += '<option value="5"' + (filter.page_size == 5 ? ' selected' : '') + '>5 条/页</option>';
	htmlData += '<option value="10"' + (filter.page_size == 10 ? ' selected' : '') + '>10 条/页</option>';
	htmlData += '<option value="20"' + (filter.page_size == 20 ? ' selected' : '') + '>20 条/页</option>';
	htmlData += '<option value="50"' + (filter.page_size == 50 ? ' selected' : '') + '>50 条/页</option>';
	htmlData += '<option value="100"' + (filter.page_size == 100 ? ' selected' : '') + '>100 条/页</option>';
	htmlData += '</select>';
	htmlData += '</span>';
	htmlData += '<span class="layui-laypage-count">共 ' + filter.record_count + ' 条，' + filter.page_count + '页</span>';
	if (listDatas.page <= 1) htmlData += '<a href="javascript:;" class="layui-disabled" style="padding-right:6px;"><i class="layui-icon layui-icon-prev"></i></a>';
	else htmlData += '<a href="javascript:listDatas.gotoPageFirst();" class="" style="padding-right:6px;"><i class="layui-icon layui-icon-prev"></i></a>';

	if (listDatas.page <= 1) htmlData += '<a href="javascript:;" class="layui-disabled" style="padding-left:6px;"><i class="layui-icon layui-icon-left"></i></a>';
	else htmlData += '<a href="javascript:listDatas.gotoPagePrev();" style="padding-left:6px;"><i class="layui-icon layui-icon-left"></i></a>';

	htmlData += '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>' + listDatas.page + '</em></span>';

	if (listDatas.page >= filter.page_count) htmlData += '<a href="javascript:;" class="layui-laypage-next layui-disabled" style="padding-right:6px;"><i class="layui-icon layui-icon-right"></i></a>';
	else htmlData += '<a href="javascript:listDatas.gotoPageNext();" class="layui-laypage-next" style="padding-right:6px;"><i class="layui-icon layui-icon-right"></i></a>';

	if (listDatas.page >= filter.page_count) htmlData += '<a href="javascript:;" class="layui-laypage-next layui-disabled" style="padding-left:6px;"><i class="layui-icon layui-icon-next"></i></a>';
	else htmlData += '<a href="javascript:listDatas.gotoPageLast();" class="layui-laypage-next" style="padding-left:6px;"><i class="layui-icon layui-icon-next"></i></a>';
	htmlData += '<span class="layui-laypage-skip">到第<input type="text" min="1" value="' + listDatas.page + '" class="layui-input jump-page" onkeyup="value=value.replace(/[^\\d]/g,\'\')">页<button type="button" class="layui-laypage-btn" style="color: #333;" onclick="listDatas.gotoPage($(\'.jump-page\').val())">确定</button></span>';
	htmlData += '</div></div></div>';
	htmlData += '</td></tr></tfoot>';
	return htmlData;
};

//首页
listDatas.gotoPageFirst = function () {
	listDatas.page = 1;
	if (listDatas.pageCount == listDatas.page) return;
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}
};
//上一页
listDatas.gotoPagePrev = function () {
	if (listDatas.page <= 1) return;
	listDatas.page--;
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}
};
//下一页
listDatas.gotoPageNext = function () {
	if (listDatas.pageCount <= listDatas.page) return;
	listDatas.page++;
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}
};
//最后页
listDatas.gotoPageLast = function () {
	listDatas.page = listDatas.pageCount
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}
};
//设置每页显示多少行
listDatas.setPerPage = function (num) {
	if (num < 1) {
		layer.msg('每页页数应大于1');
		return;
	}
	listDatas.page_size = num;
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}
};
//跳转到多少页
listDatas.gotoPage = function (num) {
	// if (listDatas.pageCount < num || num < 1) {
	//     alert('您的页码输入有误！');
	//     return;
	// }
	if (num < 1) num = 1;
	if (num > listDatas.pageCount) num = listDatas.pageCount;
	listDatas.page = num;
	if(listDatas.isTableList){
		listDatas.listData();
	}else{
		listDatas.listData2();
	}
};

//修改指定文本
listDatas.edit = function (obj, field, id, action) {
	var tag = obj.firstChild.tagName;
	if (action == undefined) action = 'editText';
	if (typeof (tag) != "undefined" && tag.toLowerCase() == "input") {
		return;
	}

	/* 保存原始的内容 */
	var org = obj.innerHTML;
	var val = Browser.isIE ? obj.innerText : obj.textContent;

	/* 创建一个输入框 */
	var txt = document.createElement("INPUT");
	txt.value = (val == 'N/A' || val == '-') ? '' : val;
	//txt.style.width = (obj.offsetWidth - 20) + "px" ;
	txt.style.width = "80px";

	/* 隐藏对象中的内容，并将输入框加入到对象中 */
	obj.innerHTML = "";
	obj.appendChild(txt);
	txt.focus();

	/* 编辑区输入事件处理函数 */
	txt.onkeypress = function (e) {
		var evt = Utils.fixEvent(e);
		var obj = Utils.srcElement(e);

		if (evt.keyCode == 13) {
			obj.blur();

			return false;
		}

		if (evt.keyCode == 27) {
			obj.parentNode.innerHTML = org;
		}
	}

	/* 编辑区失去焦点的处理函数 */
	txt.onblur = function (e) {
		if (Utils.trim(txt.value).length > 0) {
			// obj.innerHTML = (res.error == 0) ? res.content : org;
			jQuery.getJSON(listDatas.dataurl, "act=" + action + "&id=" + id + "&field=" + field + "&value=" + Utils.trim(txt.value), function (json) {
				if (json.rs == 'true') {
					obj.innerHTML = Utils.trim(txt.value);
				} else {
					layer.msg(json.error);
					obj.innerHTML = org;
				}
			});
		} else {
			obj.innerHTML = org;
		}
	}
};

//修改指定数据得状态
listDatas.changeState = function (id, field, value, type, action) {
	if (value == 1) value = 0; else value = 1;
	if (action == undefined) action = 'chgState';
	jQuery.getJSON(listDatas.dataurl, "act=" + action + "&id=" + id + "&field=" + field + "&value=" + value + "&type=" + type, function (json) {
		if (json.rs == 'true') {
			jQuery("#" + field + "_" + id).html('<img src="' + listDatas.statichost + '/images/adm/' + (value == 1 ? 'yes' : 'no') + '.gif" onclick="listDatas.changeState(' + id + ',\'' + field + '\',' + value + ',' + type + ',\'' + action + '\');" >');
		} else {
			alert('更新失败');
		}
	});
};

//全选
listDatas.selectAll = function (obj, chk) {
	if (chk == null) {
		chk = 'checkboxes';
	}

	var elems = obj.form.getElementsByTagName("INPUT");

	for (var i = 0; i < elems.length; i++) {
		if (elems[i].name == chk || elems[i].name == chk + "[]") {
			elems[i].checked = obj.checked;
		}
	}
};

//删除数据
listDatas.delItem = function (value, action) {
	if (confirm('确认删除此记录吗？') == false) return;
	if (action == undefined) action = 'delItem';
	jQuery.getJSON(listDatas.dataurl, "act=" + action + "&id=" + value, function (json) {
		if (json.rs == 'true') {
			if(listDatas.isTableList){
				listDatas.listData();
			}else{
				listDatas.listData2();
			}
		} else {
			alert(json.msg);
		}
	});
};

// 数据列表加载完成触发方法
listDatas.loadComplete = function () {
};

// 设置获取列表数据源方法名称
listDatas.dataSourceCallback = 'getList';

// 搜索回调方法
listDatas.searchCallback = function () {
};

// 搜索重置回调方法
listDatas.resetCallback = function () {
};

// 执行搜索操作
listDatas.doSearch = function () {
	$('.filter-search').click();
};

// 表格头部按钮组
listDatas.headerBtnGroup = function (btns, extAttrs) {
	if (typeof btns == 'object') {

		var _btns = '';
		var _extAttrs = '';
		if (extAttrs != undefined) _extAttrs = extAttrs;
		$.each(btns, function (i, n) {
			_btns += n;
		});

		var _disabled = '';
		// if(btns.lfength==0){
         //    _disabled = 'disabled';
		// }

		var _html = `
			<div class="input-group input-group-sm">
				<span  class="input-group-addon" style="line-height: 0px;box-sizing: border-box;">
					<input ${_disabled} class="cb-item cb-item-main"  style="display: inline-table;" type="checkbox" ${_extAttrs}>
				</span>
				<div class="input-group-btn" >
					<button ${_disabled} type="button" class="btn btn-sm dropdown-toggle btn-nospin btn-default" data-toggle="dropdown"><i class="fa fa-angle-down "></i></button>
					<ul class="pull-left page-list-actions dropdown-menu" role="menu">
						<li>${_btns}</li>
					</ul>
				</div>
			</div>
		`;

		$(listDatas.containerID).find('tr:first > th:first').html(_html);
	}
};

// 列表按钮组
listDatas.btnGroup = function (btns, id, extAttrs, disabled) {
	if (typeof btns == 'object') {
		var _btns = '';
		var _id = 0;
		var _extAttrs = '';
		var _disabled = '';
		if (id != undefined) _id = id;
		if (extAttrs != undefined) _extAttrs = extAttrs;
		if (disabled != undefined && disabled == true) _disabled = 'disabled';
		$.each(btns, function (i, n) {
			_btns += n;
		});
		var _html = `
            <div class="input-group input-group-sm">
                <span class="input-group-addon" style="line-height: 0px;box-sizing: border-box;">
                    <input class="cb-item cb-item-sub" ${_disabled} style="display: inline-table;" type="checkbox" data-id="${_id}" ${_extAttrs}>
                </span>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-sm dropdown-toggle btn-nospin btn-default" data-toggle="dropdown" ${_disabled}><i class="fa fa-angle-down "></i></button>
                    <ul class="pull-left page-list-actions dropdown-menu" role="menu">
                        ${_btns}
                    </ul>
                </div>
            </div>
        `;
		return _html;
	} else {
		return '';
	}
};

$(document).ready(function () {
	var _listDataSourceFn;
	var _cbMain = 0;
	var _checked;

	// 绑定搜索
	$('.filter-search').on('click', function () {
		listDatas.isSearch = 1;
		listDatas.page = 1;
		listDatas.searchCallback();
		try {
			_listDataSourceFn = eval(listDatas.dataSourceCallback);
		} catch (ex) {
			layer.msg('【' + listDatas.dataSourceCallback + '】方法不存在');
		}
		if (typeof _listDataSourceFn == 'function') {
			_listDataSourceFn.call();
		}
		return false;
	});

	// 绑定搜索重置
	$('.filter-reset').on('click', function () {
		listDatas.params = [];
		listDatas.isSearch = 0;//是否是搜索
		listDatas.page = 1;
		$('textarea.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])').each(function () {
			$(this).val("");
		});
		listDatas.resetCallback();
		try {
			_listDataSourceFn = eval(listDatas.dataSourceCallback);
		} catch (ex) {
			layer.msg('【' + listDatas.dataSourceCallback + '】方法不存在');
		}
		if (typeof _listDataSourceFn == 'function') {
			_listDataSourceFn.call();
		}
		return false;
	});

	// 绑定搜索input框键盘事件
	$('input.form-filter').on('keyup', function (e) {
		if(e.keyCode == 27){
			$(this).val('');
		}
	});

	// 复选框事件绑定
	$(document).on('click', '.cb-item', function () {
		_cbMain = $(this).hasClass('cb-item-main') ? 1 : 0;
		_checked = $(this).is(':checked');
		if (_cbMain == 1) { // 全选/非全选
			$('.cb-item-sub').prop('checked', _checked);
		} else { // 单选
			if ($('.cb-item-sub:checked').length != $('.cb-item-sub').length) {
				$('.cb-item-main').prop('checked', false);
			} else {
				$('.cb-item-main').prop('checked', true);
			}
		}
	});

	// 如果表格第一列头部无描述或头部是复选框，则设置该列宽度为50px
	if ($.trim($(listDatas.containerID).find('tr:first > th:first').html()) == '' || $(listDatas.containerID).find('tr:first > th:first').find('input[type=checkbox]').length > 0) {
		$(listDatas.containerID).find('tr:first > th:first').css('width', 50);
	}

	if ($('.table-tools').length) {
		var _historyFilter = getColumnFilter();
		var _thFilter = `
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="筛选列">
                        <span class="layui-icon layui-icon-cols">&nbsp;</span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">`;
		$(listDatas.containerID + ' tr:first th').each(function (i, n) {
			if ($(n).html() != '' && $(n).find('input[type=checkbox]').length == 0) {
				if (_historyFilter.indexOf($(n).html()) != -1) {
					_thFilter += `<li><label style="display: inline-flex;"><input type="checkbox" class="table-filter" style="width:15px;height:15px;margin-left:10px;margin-right:5px;" data-pos="${i}" /> ${$(n).html()}</label></li>`;
					checkHeaderColumnFilter(i, false);
				} else {
					_thFilter += `<li><label style="display: inline-flex;"><input type="checkbox" class="table-filter" style="width:15px;height:15px;margin-left:10px;margin-right:5px;" data-pos="${i}" checked /> ${$(n).html()}</label></li>`;
				}
			}
		});
		_thFilter += `</ul></div>`;
		$('.table-tools').html(_thFilter);

		$('.table-filter').on('change', function () {
			checkHeaderColumnFilter($(this).data('pos'), $(this).is(':checked'));
			saveColumnFilter();
		});
	}
});

function checkHeaderColumnFilter(pos, isChecked){
	if (!isChecked) {
		$(listDatas.containerID + ' tr:first th').eq(pos).hide();
		$(listDatas.container+' table tbody:first tr').each(function (i, n) {
			$(n).find('td').eq(pos).hide();
		});
	} else {
		$(listDatas.containerID + ' tr:first th').eq(pos).show();
		$(listDatas.container+' table tbody:first tr').each(function (i, n) {
			$(n).find('td').eq(pos).show();
		});
	}
}

function checkColumnFilter() {
	$('.table-filter').not(':checked').each(function (i, n) {
		$(listDatas.container+' table tbody:first tr').each(function (ii, nn) {
			$(nn).find('td').eq($(n).data('pos')).hide();
		});
	});
}

function saveColumnFilter() {
	var _filters = new Array();
	$('.table-filter').not(':checked').each(function (i, n) {
		_filters.push($.trim($(n).parent().text()));
	});
	window.localStorage.setItem(getColumnFilterSign(), JSON.stringify(_filters));
}

function getColumnFilter() {
	var _filters = window.localStorage.getItem(getColumnFilterSign());
	if (_filters !== undefined && _filters !== null) return JSON.parse(_filters);
	else return [];
}

function getColumnFilterSign() {
	return 'filter_' + window.location.href.replace(window.location.protocol + '//' + window.location.hostname + '/', '');
}