<?php

/**
 * Class to group some general HTML related functions
 */
class Html {
    
    /**
     * Returns the beginning of the string specified by length. Adds three dots to the end of truncated string.
     * @param type $string
     * @param type $length
     * @return type
     */
    public static function truncate($string, $length) {
        if(mb_strlen($string, 'UTF-8') > $length) {
            return mb_substr($string, 0, $length, 'UTF-8') . '...';
        }
        else {
            return $string;
        }
    }
}