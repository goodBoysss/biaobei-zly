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

                var url = "http://biaobei.zly.lh/api/generate/sound?voice_name=" + voice_name + "&text=" + text;
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
    </select>
    <textarea name="" id="text" cols="30" rows="10" style="width: 100%" placeholder="输入文字"></textarea>
    <button style="margin-top: 30px" id="bt">生成语音</button>
</div>

</body>
<html>