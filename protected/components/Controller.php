<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        if (Yii::app()->params['authentication']['required']) {
            return array(
                array('deny',
                    'users' => array('?'),
                ),
            );
        } else {
            return array();
        }
    }

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    public function beforeAction($action)
    {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                        Yii::getPathOfAlias('webroot.js.timeago') . '/timeago.js'
                )
        );
        if(Yii::app()->language != 'en') {
            $path =  Yii::getPathOfAlias('webroot.js.timeago') . '/timeago.' . Yii::app()->language . '.js';
            if(file_exists($path))
            Yii::app()->clientScript->registerScriptFile(
                    Yii::app()->assetManager->publish($path)
            );
        }
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                        Yii::getPathOfAlias('webroot.js') . '/general.js'
                )
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                        Yii::getPathOfAlias('webroot.js.highcharts') . '/highcharts.js'
                )
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                        Yii::getPathOfAlias('webroot.js.highcharts') . '/highcharts-more.js'
                )
        );
        Yii::app()->clientScript->registerCssFile(
                Yii::app()->assetManager->publish(
                        Yii::getPathOfAlias('webroot.css') . '/app.css'
                )
        );
        return parent::beforeAction($action);
    }

}