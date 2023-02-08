<?php
/**
 * ShortKey.php
 * ==============================================
 * Copy right 2015-2023  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc: 短连接key生成
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2023/02/08
 * @version: v1.0.0
 * @since: 2023/02/08 18:24
 */


namespace App\Common;

class ShortKey
{
    //关键字
    private $keywords = array();

    //偏移量关系
    private $keywordsLength;

    //字符串长度
    private $strLength;

    //偏移量对应关系
    private $viRel = array();

    public function __construct()
    {
        $this->keywords = ["u", "f", "i", "0", "1", "e", "v", "2", "w", "s", "y", "U", "T", "H", "O", "V", "c", "R", "J", "F", "r", "S", "L", "D", "A", "Z", "E", "K", "M", "k", "b", "Q", "q", "B", "g", "x", "h", "6", "7", "5", "l", "z", "C", "o", "t", "Y", "4", "9", "I", "P", "3", "p", "W", "d", "G", "8", "j", "X", "m", "N", "n", "a"];
        $this->keywordsLength = count($this->keywords);
    }

    /**
     * @desc: 生成下一个字符串
     * @param $currentStr
     * @param int $strVi
     * @return mixed|string
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 18:40
     */
    public function next($currentStr, $strVi = 0)
    {
        if (!isset($this->strLength)) {
            $this->strLength = strlen($currentStr);
        }

        if (isset($this->viRel[$strVi])) {
            $keywordsVi = $this->viRel[$strVi];
        } else {
            $keywordsVi = array_search($currentStr[$this->strLength - 1 - $strVi], $this->keywords);
            $this->viRel[$strVi] = $keywordsVi;
        }
        $keywordsVi++;

        $nextStr = $currentStr;
        if ($keywordsVi < $this->keywordsLength - 1) {
            $nextStr[$this->strLength - 1 - $strVi] = $this->keywords[$keywordsVi];
            $this->viRel[$strVi] = $keywordsVi;
        } else {
            if ($strVi < $this->strLength - 1) {
                $nextStr[$this->strLength - 1 - $strVi] = $this->keywords[0];
                $this->viRel[$strVi] = 0;
                $nextStr = $this->next($nextStr, $strVi + 1);
            } else {
                $nextStr[$this->strLength - 1 - $strVi] = $this->keywords[0];
                $nextStr = "{$this->keywords[0]}{$nextStr}";
                $this->strLength++;
                $this->viRel[$strVi] = 0;
            }

        }

        return $nextStr;
    }

}