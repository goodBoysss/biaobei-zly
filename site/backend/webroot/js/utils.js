/* $Id : utils.js 5052 2015-02-03 10:30:13Z gaorq $ */

var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var Utils = new Object();

Utils.htmlEncode = function(text)
{
  return text.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

Utils.trim = function( text )
{
  if (typeof(text) == "string")
  {
    return text.replace(/^\s*|\s*$/g, "");
  }
  else
  { 
    return text;
  }
}

Utils.isEmpty = function( val )
{
  switch (typeof(val))
  {
    case 'string':
      return Utils.trim(val).length == 0 ? true : false;
      break;
    case 'number':
      return val == 0;
      break;
    case 'object':
      return val == null;
      break;
    case 'array':
      return val.length == 0;
      break;
    default:
      return true;
  }
}

Utils.isNumber = function(val)
{
  var reg = /^[\d|\.|,]+$/;
  return reg.test(val);
}

Utils.isInt = function(val)
{
  if (val == "")
  {
    return false;
  }
  var reg = /\D+/;
  return !reg.test(val);
}

Utils.isEmail = function( email )
{
  var reg1 = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;

  return reg1.test( email );
}

Utils.isTel = function ( tel )
{
  var reg = /^[\d|\-|\s|\_]+$/; //只允许使用数字-空格等
  return reg.test( tel );
}


Utils.isPhone = function ( phone )
{
  var reg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
  return reg.test( phone );
}

Utils.fixEvent = function(e)
{
  var evt = (typeof e == "undefined") ? window.event : e;
  return evt;
}

Utils.srcElement = function(e)
{
  if (typeof e == "undefined") e = window.event;
  var src = document.all ? e.srcElement : e.target;

  return src;
}

Utils.isDate = function(val)
{
  var reg = /^\d{4}-\d{2}-\d{2}$/;

  return reg.test(val);
}

Utils.isTime = function(val)
{
  var reg = /^\d{2}:\d{2}:\d{2}$/;

  return reg.test(val);
}

Utils.isDatetime = function(val)
{
  var reg = /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/;

  return reg.test(val);
}


Utils.isURL = function(str_url) {// 验证url
     var reg = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
     return reg.test(str_url);
}



Utils.x = function(e)
{ //当前鼠标X坐标
    return Browser.isIE?event.x + document.documentElement.scrollLeft - 2:e.pageX;
}

Utils.y = function(e)
{ //当前鼠标Y坐标
    return Browser.isIE?event.y + document.documentElement.scrollTop - 2:e.pageY;
}

Utils.request = function(url, item)
{
	var sValue=url.match(new RegExp("[\?\&]"+item+"=([^\&]*)(\&?)","i"));
	return sValue?sValue[1]:sValue;
}

Utils.$ = function(name)
{
    return document.getElementById(name);
}

Utils.suffixIcon = function(suffix){
	var base_url = '/images/suffix/';
	var suffixArr = ['accdb','avi','bmp','css','docx','eml','eps','fla','gif',
	                 'html','ind','ini','jpeg','jsf','midi','mov','mp3','mpeg',
	                 'pdf','png','pptx','pptx','proj','psd','pst','pub','rar',
	                 'readme','settings','text','tiff','url','vsd','wav','wma',
	                 'wmv','xlsx','zip'];
    return base_url+suffix+".png";
}


function checkFormParams(id,type,note,required,callBack){
	var val =Utils.trim(Utils.$(id).value);
	if(required==true&&val==''){  //如果是必填项,0也算填写了值
		callBack(note+"不能为空");
		return false;
	}else if(val!=''){
		switch(type){
			case 'int': 
				if(!Utils.isInt(val)){
					callBack(note+"必须为整型");
					return false;
				}
				break;
			
			case 'float': {
				if(!Utils.isNumber(val)){
					callBack(note+"必须为数字");
					return false;
				}
				break;
			}
			case 'date':{
				if(!Utils.isDate(val)){
					callBack(note+"必须为日期:1970-01-01格式");
					return false;
				}
				break;
			} 
			case 'time':{
				if(!Utils.isTime(val)){
					callBack(note+"必须为时间:00:00:00格式");
					return false;
				}
				break;
			} 
			case 'datetime': {
				if(!Utils.isDatetime(val)){
					callBack(note+"必须为时间日期:1970-01-01 00:00:00格式");
					return false;
				}
				break;
			}
			case 'string':{
				 
				 break;
			}
			case 'email':{
					if(!Utils.isEmail(val)){
						callBack(note+"必须为邮件格式:example@mail.com");
						return false;
					}
				 	break;
				}
			case 'phone':{
				if(!Utils.isPhone(val)){
					callBack(note+"格式不正确");
					return false;
				}
			 	break;
			}
			case 'tel':{
					if(!Utils.isTel(val)){
						callBack(note+"格式不正确");
						return false;
					}
				 	break;
				}
            case 'url':{
                if(!Utils.isURL(val)){
                    callBack(note+"格式不正确");
                    return false;
                }
                break;
            }

		}	
	}
	return val;
}

//在ie下兼容placeholder
Utils.placeholder = function(element,color) {
    var placeholder = '';
    if (element && !("placeholder" in document.createElement("input")) && (placeholder = element.getAttribute("placeholder"))) {
        element.onfocus = function() {
            if (this.value === placeholder) {
                this.value = "";
            }
            this.style.color = '';
        };
        element.onblur = function() {
            if (this.value === "") {
                this.value = placeholder;
                this.style.color = color;    
            }
        };
        
        //样式初始化
        if (element.value === "") {
            element.value = placeholder;
            element.style.color = color;   
        }
    }
}

Utils.str_repeat = function(rstr,len){
	var rsStr = '';
	for(var i=0;i<len;i++){
		reStr += rstr;
	}
	return rsStr;
}


/**
 * 获取上传文件大小（默认B）
 * @param sting[file对象] target
 * @param sting[单位,默认B,(B,KB,MB)] type
 */
Utils.getFileSize  = function (target,type) {
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
	var size = fileSize;
	if(type=='KB') size=fileSize/1024;
	if(type=='MB') size=fileSize/(1024*1024);
	return size;
} 

function rowindex(tr)
{
  if (Browser.isIE)
  {
    return tr.rowIndex;
  }
  else
  {
    table = tr.parentNode.parentNode;
    for (i = 0; i < table.rows.length; i ++ )
    {
      if (table.rows[i] == tr)
      {
        return i;
      }
    }
  }
}

document.getCookie = function(sName)
{
  // cookies are separated by semicolons
  var aCookie = document.cookie.split("; ");
  for (var i=0; i < aCookie.length; i++)
  {
    // a name/value pair (a crumb) is separated by an equal sign
    var aCrumb = aCookie[i].split("=");
    if (sName == aCrumb[0])
      return decodeURIComponent(aCrumb[1]);
  }

  // a cookie with the requested name does not exist
  return null;
}

document.setCookie = function(sName, sValue, sExpires)
{
  var sCookie = sName + "=" + encodeURIComponent(sValue);
  if (sExpires != null)
  {
    sCookie += "; expires=" + sExpires;
  }

  document.cookie = sCookie;
}

document.removeCookie = function(sName,sValue)
{
  document.cookie = sName + "=; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
}

function getPosition(o)
{
    var t = o.offsetTop;
    var l = o.offsetLeft;
    while(o = o.offsetParent)
    {
        t += o.offsetTop;
        l += o.offsetLeft;
    }
    var pos = {top:t,left:l};
    return pos;
}

function cleanWhitespace(element)
{
  var element = element;
  for (var i = 0; i < element.childNodes.length; i++) {
   var node = element.childNodes[i];
   if (node.nodeType == 3 && !/\S/.test(node.nodeValue))
     element.removeChild(node);
   }
}

function showNotice(objId)
{
  var obj = document.getElementById(objId);

  if (obj)
  {
    if (obj.style.display != "block")
    {
      obj.style.display = "block";
    }
    else
    {
      obj.style.display = "none";
    }
  }
}


function stopBubble(){
	var oEvent = window.event || arguments.callee.caller.arguments[0];
	try{
		oEvent.cancelBubble = true;
		oEvent.returnValue = false;
		oEvent.stopPropagation();
		oEvent.preventDefault();
	}catch(err){}
}
