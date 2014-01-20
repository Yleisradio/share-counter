<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
                require(dirname(__FILE__) . '/common.php'), array(
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            'name' => 'Kato Ite Console Application',
            // preloading 'log' component
            'preload' => array('log'),
            // application components
            'import' => array(
                'application.models.*',
                'application.components.*',
            ),
            'components' => array(
                // Use this to override the db config
                /*
                  'db' => array(
                  'connectionString' => 'mysql:host=localhost;dbname=dbname',
                  'emulatePrepare' => true,
                  'username' => 'dbusername',
                  'password' => 'dbpassword',
                  'charset' => 'utf8',
                  ),
                 */
                'cache' => array(
                    'class' => 'CApcCache',
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, warning, info',
                        ),
                    ),
                ),
            ),
            'params' => array(
                //Optional Http Proxy to access the internet
//                'httpProxy' => array(
//                    'host' => 'httpproxyaddress.com',
//                    'port' => '80'
//                ),
                //Feeds where articles are searched from
                'feeds' => array(
//                    'http://yle.fi/uutiset/rss/uutiset.rss',
//                    'http://yle.fi/urheilu/rss/uutiset.rss',
//                    'http://yle.fi/uutiset/rss/uutiset.rss?osasto=news',
//                    'http://svenska.yle.fi/rss/articles/all',
                ),
                //Can be used to decrease the number of Http requests to increase the performance
                //List of domains which give the same address from the xml feed and canonical html tag or canonical html tag is missing
                'skipCanonical' => array(
//                    'yle.fi',
                ),
                'apiLogLevel' => 'error', //Possible values: 'all', 'error', 'none'
            ),
                )
);
