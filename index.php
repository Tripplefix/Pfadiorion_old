<?php

/**
 * A simple, clean and secure PHP Login Script
 *
 * MVC FRAMEWORK VERSION
 * Check GitHub for other versions
 * Check develop branch on GitHub for bleeding edge versions
 *
 * A simple PHP Login Script embedded into a small framework.
 * Uses PHP sessions, the most modern password-hashing and salting
 * and gives all major functions a proper login system needs.
 *
 * @package php-login
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login/
 * @license http://opensource.org/licenses/MIT MIT License
 */
// dev error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !<br />Installed Version: " . PHP_VERSION);
}

// loading config
require 'config/config.php';
// loading the Official PHP Password Hashing Compatibility Library (see more in the README file)
require 'libs/external/PasswordCompatibilityLibrary.php';

// the autoloading function, which will be called every time a file "is missing"
// NOTE: don't get confused, this is not "__autoload", the now deprecated function
// The PHP Framework Interoperability Group (@see https://github.com/php-fig/fig-standards) recommends using a
// standardized autoloader https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md, so we do:
function autoload($class) {

    // if file does not exist in LIBS folder [set it in config/config.php],
    // then check in LIBS/external
    if (file_exists(LIBS . $class . ".php")) {
        require LIBS . $class . ".php";
    } else {
        require LIBS . "external/" . $class . ".php";
    }
}

// spl_autoload_register defines the function that is called every time a file is missing. as we created this
// function above, every time a file is needed, autoload(THENEEDEDCLASS) is called
spl_autoload_register("autoload");

// start our app
$app = new Bootstrap();
