<html>
<head>
    <script src="/js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#bt").click(function () {
                var voice_name = $("#voice_name").val();
                var text = $("#text").val();

                if (text == "") {
                    alert("生成语音文本内容不能为空")
                }

                var url = "http://119.45.173.60/api/generate/sound?voice_name=" + voice_name + "&text=" + text;
                window.open(url, '_blank');

            });
        });
    </script>
</head>
<body>
<div style="width: 60%;margin-left: 20%">
    <h1>语音生成</h1>
    <select name="" id="voice_name" style="width: 100%;margin-bottom: 30px">
        <option value="v00022bbe39adcab88bbbdbb60d35b9e1028f8lznb">张凌云</option>
        <option value="v000246e5f4505635f22d826ebeaf520f8f8aj5u9e">老婆_01</option>
        <option value="v0002513d66b46eb9a31d62b7e6c1e2aefa58ffeor">天明路_优化（旧）</option>
        <option value="v0002d92dd13e773e51f9d53bfd839a6f6caciat5n">天明路_优化（新）</option>
        <option value="v000281fc5adc20b9cf200f8ca30ab38316bfkilhu">杭州25个宝妈（增强）</option>
    </select>
    <textarea name="" id="text" cols="30" rows="10" style="width: 100%" placeholder="输入文字"></textarea>
    <button style="margin-top: 30px" id="bt">生成语音</button>
</div>

</body>
<html>