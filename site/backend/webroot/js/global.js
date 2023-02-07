

//获取区域信息
//type:1-城市；2-区域
function getRegions(obj,type,class_city,class_area){
    var parentId = $.trim($(obj).val());
    var class_city = class_city?class_city:'no_area_city';
    var class_area = class_area?class_area:'no_area_area';

    var htmlData = '<option selected value="">'+(type==1?'市':'区域、县级市')+'</option>';
    if(parentId==''||parentId<=0){
        if(type==1){
            $('.'+class_city).html(htmlData);
            $('.'+class_area).html('<option selected value="" >区域、县级市</option>');
        }else if(type==2){
            $('.'+class_area).html(htmlData);
        }
        return false;
    }

    $.getJSON('/region/getRegions?parentId='+parentId,function(data){
        if(data.error==undefined){
            if(data.num_items>0){
                for(n in data.items){
                    htmlData+='<option value="'+data.items[n].region_id+'">'+data.items[n].region_name+'</option>';
                }
            }
        }
        if(type==1){
            $('.'+class_city).html(htmlData);
            $('.'+class_area).html('<option selected value="" >区域、县级市</option>');
        }else if(type==2){
            $('.'+class_area).html(htmlData);
        }
    });
}


//选择上传文件
function seltUpFile(obj,size){
    if(size==undefined) size = 5*1024*1024; //默认上传大小限制为5M
    var fileInpt = $(obj).parent().parent().find('input[type="file"]')
    var crtlInpt = $(obj).parent().parent().find('input.form-control')
    fileInpt.click();
    fileInpt.change(function(){
        var filesize = Utils.getFileSize(this);
        if(filesize>size){
            var alertFunc = alert;
            if(layer.msg) alertFunc = layer.msg;
            alertFunc('上传文件过大:文件必须限制在'+(size/(1024*1024))+'MB以内！');
            return false;
        }
        crtlInpt.val(fileInpt.val());
    });
}


/**
 * 获取上传文件大小（B）
 * @param sting[file对象] target
 * @param sting[单位,默认B,(B,KB,MB)] type
 */
function getFileSize(target,type) {
    if(type==undefined) type='B';
    var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
    var fileSize = 0;
    if (isIE && !target.files) {
        var filePath = target.value;
        var fileSystem = new ActiveXObject("Scripting.FileSystemObject");
        var file = fileSystem.GetFile (filePath);
        fileSize = file.Size;
    } else {
        fileSize = target.files[0].size;
    }
    var size = 0;
    switch(type){
        case 'KB':
            size=fileSize/1024;
            break;
        case 'MB':
            size=fileSize/(1024*1024);
            break;
        default:
            size = fileSize;
    }
    return size;
}

/**
 * 打开新窗口
 * @param title[窗口标题]
 * @param url[链接地址]
 * @param width[窗口宽度]：800px、80%
 * @param height[窗口高度]
 */
function openWindow(title, url, width, height){
    layer.open({
        title:title,
        skin: 'layui-layer-rim', //加上边框
        type: 2,
        shadeClose: true,
        closeBtn:2,
        cancel: function(index, layero){
            layer.close(index); //如果设定了yes回调，需进行手工关闭
        },
        area: [width, height],
        offset: '20px',
        content: url
    });
}


/**
 * 采用正则表达式获取地址栏参数
 * @param name[链接]
 */
function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

/**
 * 替换成整数
 * @param obj
 */
function replaceInt(obj){
    $(obj).val($(obj).val().replace(/\D/g,''));
}

/**
 * 替换成浮点
 * @param obj
 * @param n 保留小数位数，不传无限制
 */
function replaceFloat(obj,n){
    var number=$(obj).val().replace(/[^\d.]/g,'');
    //出现两个小数点时去掉第二个小数点
    if(number.indexOf('.',number.indexOf(".")+1)>=0){
        index=number.indexOf('.',number.indexOf(".")+1);

        number1=number.substring(0,index);
        number2=number.substring(index+1,number.length);
        //重新组合数字
        number=number1.toString()+number2.toString();
    }

    //如果小数点在第一位
    index=number.indexOf('.');
    if (index===0){
        number=number.substring(1,number.length);
    }

    //小数位数
    if(number.toString().split(".")[1]){
        var m=number.toString().split(".")[1].length;
    }
    //保留n位小数，不四舍五入
    if(n && m && m>n){
        number=Math.floor(parseFloat(number) * Math.pow(10,n)) / Math.pow(10,n)
    }
    $(obj).val(number);
}

