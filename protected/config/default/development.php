<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/common.php'), array(
            'modules' => array(
                'gii' => array(
                    'class' => 'system.gii.GiiModule',
                    'password' => 'giipassword',
                    'ipFilters' => array('127.0.0.1', '::1'),
                ),
            ),
            'components' => array(
                'cache' => array(
                    'class' => 'CDummyCache',
                ),
                // Use this to override the db config
                /*
                  'db' => array(
                  'connectionString' => 'mysql:host=localhost;dbname=devdbname',
                  'emulatePrepare' => true,
                  'username' => 'username',
                  'password' => 'password',
                  'charset' => 'utf8',
                  ),
                 */
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, warning, info',
                        ),
                    // uncomment the following to show log messages on web pages
                    /*
                      array(
                      'class'=>'CWebLogRoute',
                      ),
                     */
                    ),
                ),
            ),
            'params' => array(
                'apiLogLevel' => 'all', //Possible values: 'all', 'error', 'none'
            ),
                )
);