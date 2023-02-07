var apiPath = 'http://api.lyxurls.lh';
var _app_key = 'www_web';
var _ak = '63d27714c7a402eebe7a3f22';
var _token='dc9630f1b9a9145b1af807b70c36377b';

function commonParams(){
    return "&"+['app_key='+_app_key,'_ak='+_ak,'_token='+_token].join('&');
}
$('#shorten').click(function() {
    var raw_url = $('#url').val();
    var domain = $('input[name="domain"]:checked').val();
    if (Utils.isURL(raw_url)) {
        var url = encodeURIComponent(raw_url);
        $.getJSON(
            apiPath+'/urls/shorten?url=' + url+"&domain="+domain+commonParams(),
            function (data) {
                if (data.meta.status == 0) {
                    $('#url').val(data.data.items.s_url);
                    var qrcode = $('#qrcode').html('').qrcode({
                        width: 200,
                        height: 200,
                        text: data.data.items.s_url
                    });
                    $('#qrcode').parent().show();
                } else {
                    $('#qrcode').parent().hide();
                    layer.msg(data.data.alert_msg,{icon: 7});
                }
            }
        )
    } else {
        $('#qrcode').parent().hide();
        layer.msg('请输入正确的url',{icon: 7});
    }
});


$('#batchShorten').click(function() {
    var raw_url = $('#raw_url').val();
    var urls =  raw_url.split("\n")
    var errUrls = [];
    for (n in urls){
       if(!Utils.isURL(urls[n])&& !Utils.isEmpty(urls[n]) ){
           errUrls.push(urls[n]);
       }
    }
    // console.log(errUrls);
    if(errUrls.length>0){
        layer.msg("存在错误地址:<br>"+errUrls.join("<br>"),{icon: 7})
        return false;
    }

    if (Utils.isURL(raw_url)) {
        var url = encodeURIComponent(raw_url);
        var params = {
            raw_url:raw_url
            ,app_key:_app_key
            ,_ak:_ak
            ,_token:_token

        };
        $.post(
            apiPath+'/urls/batchShorten',
            params,
            function (data) {
                if (data.meta.status == 0) {
                    bactchRlt(data.data.items);
                } else {
                    layer.msg(data.data.alert_msg.replace(/\n/g,"<br>"),{icon: 7});
                }
            }
            ,"json");

    } else {
        $('#qrcode').parent().hide();
        layer.msg('请输入正确的url',{icon: 7});
    }
});

function bactchRlt (items){
    var htmlData = "";
    for( n in items){
        htmlData += '<tr>' +
                    '  <td>'+items[n].url+'</td>' +
                    '  <td>'+items[n].s_url+'</td>' +
                    ' </tr>';
    }
    $('#batchUrlLayer table tbody').html(htmlData);
    layer.open({
        title:"URL结果",
        type: 1,
        content: $('#batchUrlLayer').html(),
        area: ['50%', '50%']
    });
}

$('#expand').click(function() {
    var s_url = $('#s_url').val();
    if (Utils.isURL(s_url)) {
        $.getJSON(
            apiPath+'/urls/expand?url=' + s_url+commonParams(),
            function(data) {
                if (data.meta.status == 0) {
                    $('#s_url').val(data.data.items.url);
                } else {
                    layer.msg(data.data.alert_msg,{icon: 7});
                }
            }
        )
    }else{
        layer.msg('请输入正确的url',{icon: 7});
    }
});

function supportDomains() {
    $.getJSON(
        apiPath+'/urls/domains?'+commonParams(),
        function(data) {
            if (data.meta.status == 0) {
                var items = data.data.items;
                var html = "";
                for(n in items){
                    var _checked = '';
                    if(n==0)  _checked = 'checked';
                    var domain = items[n].split('/')[2]?items[n].split('/')[2]:'';
                    if(domain) html += '<input type="radio" name="domain" value="'+domain+'" title="'+domain+'" '+_checked+'/>';
                }
                //console.log(html);
                $("#domainsList ").html(html);
                GForm.render();
            }else{
                layer.msg(data.data.alert_msg.replace(/\n/g,"<br>"),{icon: 7});
            }
        }
    );
}
var GForm ;
$(document).ready(function(){
    layui.use(['form'], function(){
        GForm = layui.form;
        supportDomains();
    });
});