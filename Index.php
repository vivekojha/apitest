<?php

include('Validation.php');
include('Configuration.php');
/*
 * It is used to get user cmd input and validate.
 */

class Index extends Validation {

    public function __construct() {
        
    }

    /*
     * It is used to get user input and validate
     */

    public function getUserInput() {
        global $argv;

        if (count($argv) < 6) {
            echo "Error: You can not enter less no of parameters.";
            exit();
        } else {
            $error = array();
            $params['username'] = $this->dataValidation($argv[1]) ? $argv[1] : $error[] = 'Error: Username can not be empty or null.';
            $params['password'] = $this->dataValidation($argv[2]) ? $argv[2] : $error[] = 'Error: Password can not be empty or null.';
            $params['repos_url'] = $this->urlValidation($argv[3]) ? $argv[3] : $error[] = 'Error: Repository url can not be empty or null.';
            $params['issue_title'] = $this->dataValidation($argv[4]) ? $argv[4] : $error[] = 'Error: Iusse title can not be empty or null.';
            $params['issue_description'] = $this->dataValidation($argv[5]) ? $argv[5] : $error[] = 'Error: Issue description can not be empty or null.';

            if (count($error) > 0) {
                echo implode('\n\n', $error);
                exit();
            } else {
                $this->callRequestProcessor($params);
            }
        }
    }

    /*
     * It is used to call request processor.
     */

    private function callRequestProcessor($params) {
        // get config array by key name through static call
        $configEndPointArray = Configuration::getConfigArrayByName('end_point');

        foreach ($configEndPointArray as $name => $url) {

            if (strpos($params['repos_url'], $name) !== false) {
                try {
                    $params['repos_url'] = $this->getAPIUrl($url, $params);
                    $processorClassName = ucfirst($name) . 'processor';
                    include("processor/$processorClassName.php");
                    $processor = new $processorClassName();
                    echo $processor->requestProcess($params);
                } catch (Exception $e) {
                    echo 'Caught exception: ', $e->getMessage(), "\n";
                }
            }
        }
    }

    /*
     * It is used to get complete api end_point.
     */

    private function getAPIUrl($url, $params) {
        $tempArr = explode('/', $params['repos_url']);
        $username = $tempArr[3];
        $repository = $tempArr[4];
        $url = str_replace('{:username}', $username, $url);
        $url = str_replace('{:repository}', $repository, $url);
        return $url;
    }

}

$obj = new Index();
$obj->getUserInput();


