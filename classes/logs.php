<?php

class Statistics{

    public static function writeLog($file, $text){
        $fileContents = file_get_contents($file);
        $text = date('d-m-Y H:i:s', time()) . " - " . $text . "\n" . $fileContents;
        file_put_contents($file, $text);
    }
}





?>