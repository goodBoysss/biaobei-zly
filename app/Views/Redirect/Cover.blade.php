<html>
<style>
    div, img, a, p {
        padding: 0;
        margin: 0;
        width: 100%;
    }
</style>

<body style='margin: 0;position: relative;'>

<div style='position: fixed ; top: 0;z-index: 1000'>
{{--    <img src='{{$info['tip_image_base64']}}' />--}}
    <img src='https://tm-shorturl-prod.obs.cn-east-3.myhuaweicloud.com/cover/open/tip.jpg'/>
    <a href="{{$info['origin_url']}}" style="margin: 0;padding: 0;">
        <p style="text-align: center;line-height: 4vw;font-size: 2em;background-color: white;">
            "浏览器"依旧出错？点击文字手动跳转</p>
    </a>
</div>

<div style="margin-top:22vw;">
    <div style="position: fixed ; top: 0;height:100%;background: rgba(115,115,115,60%);margin-top:22vw;z-index: 1000"></div>
    <img style='filter: grayscale(0%)' src='{{$info['cover_image_url']}}'/>
</div>
</body>
<html>