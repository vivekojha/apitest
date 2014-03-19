apitest
=======


----------------------
Set Up Instructions
----------------------
--Install wamp/xammp/lamp as per Machine OS.
--Copy code directory(api_test) inside www(wamp)/htdocs(xammp) folder.
-- Set PHP exe path
-- Enable Curl

-----------------------------
Command Line Argument Format
-----------------------------
-- Script accept command line argument as per below order:
     1.Username 
	 2.Password
	 3.Repository URL(https://github.com/:username/:repository)
	 4.Issue Title
	 5.Issue Description
	 	 
-- Create Complete command:  php C://wamp/www/api_test/index.php username(1) password(2) repositoty_url(3) title(4) description(5)
-- Press Enter button
-- After completion it show success/error message based on result

-------------------------------------
Config
-------------------------------------
-- It have global config array with api name as key and api url as value.
-- Use place holder for username and password and script will replace it by real value at run time.

array('end_point' => array(
            'github' => 'https://api.github.com/repos/{:username}/{:repository}/issues',
            'bitbucket' => 'https://api.bitbucket.org/1.0/repositories/{:username}/{:repository}/issues/'
    ));
	
-------------------------------------
Application Architecture
-------------------------------------
1. Config.php-- it contains global config settings. 
2. Index.php-- It is used to get command line argument and call specific processor.
3. Mainprocessor.php-- It basically contain default behaviour of each function. If you need any change then we will override corresponding method in derived class
4. Githubprocessor.php-- it is a processor for Github API.
5. Bitbucketprocessor.php-- It is a processor for Bitbucket API.
6. Validation.php-- It basically contain all validation method.

	
	
   
