<?php
class Cache {

    public static function get($fileName) {
        $fileName = ROOT.DS.'storage'.DS.'cache'.DS.$fileName;
        if (file_exists($fileName)) {
            $handle = fopen($fileName, 'rb');
            $variable = fread($handle, filesize($fileName));
            fclose($handle);
            return unserialize($variable);
        } else {
            return null;
        }
    }

    public static function set($fileName,$variable) {
        $fileName = ROOT.DS.'storage'.DS.'cache'.DS.$fileName;
        $handle = fopen($fileName, 'a');
        fwrite($handle, serialize($variable));
        fclose($handle);
    }

}
