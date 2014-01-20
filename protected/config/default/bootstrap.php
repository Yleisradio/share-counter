<?php
/**
 * This file initializes Yii application
 * Use the environemnt variable to determine which configuration is loaded
 */

//Determine if to use development or production configuration
$environment = 'development';
//$environment = 'production';

//Change the following path to point to the Yii Framework files
$yii = '/var/frameworks/yii/yii-1.1.14/framework/';

if ($environment == 'production') {
    $config =(dirname(__FILE__) . '/production.php');
} else if ($environment == 'development') {

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $config = (dirname(__FILE__) . '/development.php');

    defined('YII_DEBUG') or define('YII_DEBUG', true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}
