<?php

/*
 * It is used to store all config settings.
 */

class Configuration {

    private static $_config = array('end_point' => array(
            'github' => 'https://api.github.com/repos/{:username}/{:repository}/issues',
            'bitbucket' => 'https://api.bitbucket.org/1.0/repositories/{:username}/{:repository}/issues/'
    ));

    /*
     * prevent object creation from out side the class.
     */

    private function __construct() {
        // empty echo
    }

    public static function getConfigArrayByName($name) {
        if (isset(self::$_config[$name])) {
            return self::$_config[$name];
        }
        return null;
    }

}
