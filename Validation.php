<?php

/*
 * It is used to validate user input
 */

class Validation {
    /*
     * It is a constructor and used to set class properties at object creation time.
     */

    public function __construct() {
        
    }

    /*
     * It is used to validate url string
     * Input@
     * $url: String
     * Output: Bolean
     */

    public function urlValidation($url) {

        $urlMatchRegex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        if (preg_match($urlMatchRegex, $url))
            return true;
        else
            return false;
    }

    /*
     * It is used to validate method name.
     * Input@
     * $method: String
     * Output: Bolean
     */

    public function methodValidation($method) {

        if ($method == 'GET' || $method == 'POST')
            return true;
        else
            return false;
    }

    /*
     * It is used to validate input data.
     * Input@
     * $data: String
     * Output: Bolean
     */

    public function dataValidation($data) {

        if (!isset($data) || $data == '')
            return false;
        else
            return true;
    }

}

?>
