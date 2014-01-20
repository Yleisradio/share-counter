<?php

/*
 * These common configuration files will be used in all environments. These can be overriden in other config files.
 */
return array(
//    'id' => 'domain.com',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Social Links',
    'preload' => array(
        'log',
        'bootstrap',
    ),
    'sourceLanguage' => 'en',
    'language' => 'en',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.table.*',
        'ext.yii-mail.YiiMailMessage',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'gii67',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        ),
    ),
    // application components
    'components' => array(
        //Configure database here
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=dbname',
            'emulatePrepare' => true,
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
        ),
        //Cache to be used. See subclasses for options: http://www.yiiframework.com/doc/api/1.1/CCache 
        //CDummyCache can be used to disable caching
        'cache' => array(
            'class' => 'CApcCache',
        ),
//        'user' => array(
//            'loginUrl' => array('authentication/login', 'redirect' => $_SERVER['REQUEST_URI']),
//        ),
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'vertailu' => 'site/list',
                'sivu' => 'site/data',
            ),
            'showScriptName' => false,
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
            ),
        ),
    ),
    'params' => array(
        //Google analytics ID
        'googleAnalytics' => array(
            'id' => '',
        ),
        'apiLogLevel' => 'all', //Possible values: 'all', 'error', 'none'
        'authentication' => array(
            'required' => false,
        ),
        'feedbackEmailAddress' => 'email@example.com',
    ),
);