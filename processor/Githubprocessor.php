<?php

include('Mainprocessor.php');

class Githubprocessor extends Mainprocessor {

    public function __construct() {
        parent::__construct();
    }

    /*
     * It is used to create params string.
     * Input: Array
     * Output: String
     * 
     */

    protected function createParamString($params) {

        return json_encode(array('title' => urldecode($params['issue_title']), 'body' => urlencode($params['issue_description'])));
    }

    /*
     * It is used to filter auth information
     * Input: Array
     * Output: Array
     */

    protected function createAuthInfo($params) {

        return array('username' => $params['username'], 'password' => $params['password']);
    }

    /*
     * It is used to create basic authentication header.
     * Input@ 
     * $username: string
     * $passwprd: string
     * Output@
     * $headers : array
     */

    protected function createBasicAuthHeader($username, $password) {
        return array(
            'Content-Type:application/json',
            'Authorization: Basic ' . base64_encode("$username:$password")
        );
    }

    /*
     * It is used to parse response from API end.
     * Input: Array
     * Output: String
     */

    protected function parseRequestResponse($res) {

        $rslt = '';
        if (isset($res['message']) && count($res) == 2) {
            $rslt = "Error: " . $res['message'];
        } else if (isset($res['id'])) {
            $rslt = "Success: Issue is successfully created with following details:\n"
                    . "Id: " . $res['id'] . "\n"
                    . "Number: " . $res['number'] . "\n"
                    . "Title: " . $res['title'] . "\n";
        }
        return $rslt;
    }

}

?>
