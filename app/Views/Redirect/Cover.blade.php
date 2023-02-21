<html>
<style>
    div,img, a, p {
        padding: 0;
        margin: 0;
        width: 100%;
    }
</style>

<body style='margin: 0;position: relative;'>

<div style='position: fixed ; top: 0;z-index: 1000'>
    <img style='' src='https://tm-shorturl-prod.obs.cn-east-3.myhuaweicloud.com/cover/open/tip.jpg'
         width='100%'/>
    <a href="{{$info['origin_url']}}" style="margin: 0;padding: 0;">
        <p style="text-align: center;line-height: 2em;font-size: 2em;background-color: white;">
            "浏览器"依旧出错？点击文字手动跳转</p>
    </a>
</div>


<img style='padding-top:17.5vw;filter: grayscale(0%)' src='{{$info['cover_image_url']}}' width='100%'/>
</body>
<html>