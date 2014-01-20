<?php

/**
 * This command updates metrics from social media websites. Should be run every 5 minutes by crontab.
 */
class UpdateCommand extends CConsoleCommand
{

    public function run($args)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'not_changed ASC, updated ASC';
        $criteria->limit = 1000;

        $transaction = Yii::app()->db->beginTransaction();
        $updateCount = 0;
        try {
            foreach (Site::model()->findAll($criteria) as $site) {
                var_dump($site->url);
                $updatedSince = (time() - $site->updated);
                //Update less frequently if there has been no new social media shares in the past updates
                if (!$site->updated || $updatedSince > ((pow((($site->not_changed + 1) * ($site->not_changed + 1)), 2) * 15) * 60)) {
                    $site->updateMetrics();
                    $updateCount++;
                }
                if($updateCount == 300) {
                    break;
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

}