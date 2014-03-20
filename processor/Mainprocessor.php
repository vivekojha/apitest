<?php

/*
 * It basically conatain default behaviour of each function.
 * It accept request input params and create query string/headers for the same.
 */

class Mainprocessor {
    /*
     * It is a constructor that is called at the object creation.
     */

    public function __construct() {
        
    }

    /*
     * It is used to process the request.
     * Input@: Array ($username: String, $password: String, $url: String, $issueTitle: String, $issueDescription: String)
     * Output@: String
     */

    public function requestProcess($data) {
        $authInfo = $this->createAuthInfo($data);
        $paramString = $this->createParamString($data);
        $rslt = $this->makeCURLRequest($data['repos_url'], 'POST', $paramString, $authInfo);
        return $this->parseRequestResponse(json_decode($rslt, 1));
    }

    public function makeCURLRequest($url, $method, $dataString, $authInfo) {


        $ch = curl_init();
        if ($method == 'GET') {
            // Create Url string with query params
            $urlStringData = $url . '?' . $dataString;
            curl_setopt($ch, CURLOPT_URL, $urlStringData);
        } elseif ($method == 'POST') {
            $headers = $this->createBasicAuthHeader($authInfo['username'], $authInfo['password']);
            curl_setopt($ch, CURLOPT_URL, $url);

            // Set post data string as a json/query format 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            // Set basic authentication header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        }

        // Set username as an user agent
        curl_setopt($ch, CURLOPT_USERAGENT, $authInfo['username']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

         $content = curl_exec($ch);
        if ($content === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception('Curl error in url : ' . $url . " " . $error);
        } else {
            curl_close($ch);
            return $content;
        }
    }

    protected function createParamArray($params) {

        return array('title' => $params['issue_title'], 'body' => $params['issue_description']);
    }

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
