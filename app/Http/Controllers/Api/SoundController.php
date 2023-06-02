<?php
/**
 * UrlController.php
 * ==============================================
 * Copy right 2015-2021  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 应用数据
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2023/02/08
 * @version: v1.0.0
 * @since: 2023/02/08 09:11
 */

namespace App\Http\Controllers\Api;

use App\Enums\ContextEnum;
use App\Exceptions\BasicException;
use App\Http\Controllers\BaseController;
use App\Response\Response;
use App\Services\BiaoBeiService;
use Illuminate\Http\Request;

class SoundController extends BaseController
{

    public function generateSound(Request $request)
    {
        $voiceName = $request->input("voice_name");
        $text = $request->input("text");

        $s = new BiaoBeiService();
        $content = $s->generateSound($voiceName, $text);

        $path = storage_path() . "/sound/" . date("Y-m-d");
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $filename = uniqid() . ".mp3";
        $file = fopen($path . "/" . $filename, "w") or die("无法打开文件！");
        fwrite($file, $content);
        fclose($file);


        return response()->download($path . "/" . $filename, uniqid() . ".mp3", array(
            "Content-Type" => "audio/mp3"
        ));

//        return response()->make($content, 200, array(
//            "Content-Type" => "audio/mp3"
//        ));
    }


}