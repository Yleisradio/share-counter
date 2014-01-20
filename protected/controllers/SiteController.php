<?php

/**
 * Controller which includes all the urls which return HTML
 */
class SiteController extends Controller
{

    /**
     * Home page
     */
    public function actionIndex()
    {
        //Added Sites
        $criteria = new CDbCriteria;
        $criteria->AddInCondition('url', Yii::app()->user->getState('sites'));

        $sort = new CSort();
        $sort->defaultOrder = array(
            'published' => CSort::SORT_DESC,
        );
        $addedSites = new CActiveDataProvider('Site', array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));

        $sites = null;


        $site = new Site();

        $this->render('index', array(
            'site' => $site,
            'addedSites' => $addedSites,
            'gridViewSettings' => Site::gridViewSettings(),
            'sites' => $sites,
        ));
    }

    /**
     * Add new website
     */
    public function actionAdd()
    {
        $url = Site::trimUrl($_POST['Site']['url']);
        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
            $url = 'http://' . $url;
        }
        if (Curl::get($url)) {
            $site = Site::model()->findByAttributes(array('url' => $url));
            if (!$site) {
                $site = new Site();
                $site->url = $url;
                $site->save();
                $site->id = Yii::app()->db->lastInsertId;
                $site->updateMetrics();
                $site->determineAuthorsAndOrganizations();
            }
            $sites = Yii::app()->user->getState('sites');
            if (!$sites)
                $sites = array();
            $sites[] = $site->url;
            Yii::app()->user->setState('sites', $sites);

            $this->redirect(array('site/data', 'url' => $url));
        }
        else {
             $this->redirect(array('/'));
        }
    }

    /**
     * Error page
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Detailed data page
     * @param type $url
     * @throws CHttpException
     */
    public function actionData($url)
    {
        $site = Site::model()->findByAttributes(array('url' => $url));
        if (!$site)
            throw new CHttpException(404, 'Not Found');
        $this->render('data', array(
            'site' => $site,
        ));
    }

    /**
     * Lists all tracked sites
     */
    public function actionList()
    {
        //All Sites
        $allSites = new Site('search');
        $allSites->unsetAttributes();
        if (isset($_GET['Site']))
            $allSites->attributes = $_GET['Site'];

        $this->render('list', array(
            'allSites' => $allSites,
            'gridViewSettings' => Site::gridViewSettings(),
        ));
    }

}