<?php

/**
 * Description of RandomName
 *
 * @author Ali
 */
class RandomName {

    public function __construct() {
        
    }

    static public function generateName($len, $type) {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $num = "1234567890";
        $spc = "-_.";
        $chars = "";
        switch ($type) {
            case 0:
                $chars = $alpha;
                break;
            case 1:
                $chars = $num;
                break;
            case 2:
                $chars = $spc;
                break;
            case 3:
                $chars = $alpha . $num;
                break;
            case 4:
                $chars = $alpha . $spc;
                break;
            case 5:
                $chars = $num . spc;
                break;
        }
        $name = "";
        $charLen = strlen($chars) - 1;
        for ($i = 0; $i < $len; $i++) {
            $randomNum = rand(0, $charLen);
            $name .= $chars{$randomNum};
        }
        return $name;
    }

}

abstract class CharType {

    const ALPHA = 0;
    const NUM = 1;
    const SPC = 2;
    const ALPHANUM = 3;
    const ALPHASPC = 4;
    const NUMSPC = 5;

}
