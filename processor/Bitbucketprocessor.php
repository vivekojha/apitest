<?php

/*
 * It is a request processor for BitBucket API.
 */

include('Mainprocessor.php');

class Bitbucketprocessor extends Mainprocessor {

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

        return http_build_query(array('title' => urlencode($params['issue_title']),
            'content' => urlencode($params['issue_description'])));
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
        if (!isset($res) || empty($res)) {
            $rslt = "Error: Bad request due to incorrect input params.";
        } else if (isset($res['local_id'])) {
            $rslt = "Success: Issue is successfully created with following details:\n"
                    . "Id: " . $res['local_id'] . "\n"
                    . "Title: " . $res['title'] . "\n"
                    . "Content: " . $res['content'] . "\n";
        }
        return $rslt;
    }

}

?>
