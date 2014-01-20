<?php

/**
 * Command to export the metrics to a csv file that is easy to use for other purposes
 */
class GetMetricsCommand extends CConsoleCommand
{

    public function run()
    {
        var_dump(date('H:i:s'));
        $fh = fopen('data/metrics.csv', 'w');
        fputcsv($fh, array(
            'Otsikko',
            'Osoite',
            'Sivu ID',
            'Mittausaika',
            'Facebook jaot',
            'Facebook tykkäykset',
            'Facebook kommentit',
            'Tweetit',
            'LinkedIn jaot',
        ));
        $sql = '
                SELECT site.title, site.url, site_id, FROM_UNIXTIME(timestamp), SUM(social.facebook_shares), SUM(social.facebook_likes), SUM(social.facebook_comments), SUM(social.tweets), SUM(social.linkedin_shares)
                FROM (

                SELECT site_id, TIMESTAMP, value AS facebook_shares, 0 AS facebook_likes, 0 AS facebook_comments, 0 AS tweets, 0 AS linkedin_shares
                FROM  `metric` 
                WHERE TYPE = 1

                UNION 

                SELECT site_id, TIMESTAMP, 0 AS facebook_shares, value AS facebook_likes, 0 AS facebook_comments, 0 AS tweets, 0 AS linkedin_shares
                FROM  `metric` 
                WHERE TYPE = 2

                UNION
                SELECT site_id, TIMESTAMP, 0 AS facebook_shares, 0 AS facebook_likes, value AS facebook_comments, 0 AS tweets, 0 AS linkedin_shares
                FROM  `metric` 
                WHERE TYPE = 3

                UNION
                SELECT site_id, TIMESTAMP, 0 AS facebook_shares, 0 AS facebook_likes, 0 AS facebook_comments, value AS tweets, 0 AS linkedin_shares
                FROM  `metric` 
                WHERE TYPE = 4

                UNION
                SELECT site_id, TIMESTAMP, 0 AS facebook_shares, 0 AS facebook_likes, 0 AS facebook_comments, 0 AS tweets, value AS linkedin_shares
                FROM  `metric` 
                WHERE TYPE = 5

                ) AS social
                INNER JOIN site ON site.id = site_id
                GROUP BY site_id, MONTH(FROM_UNIXTIME(timestamp)), DAY(FROM_UNIXTIME(timestamp)), HOUR(FROM_UNIXTIME(timestamp)), MINUTE(FROM_UNIXTIME(timestamp))


                        ';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll();


        foreach ($metrics as $metric) {
            fputcsv($fh, $metric);
        }
        fclose($fh);
        var_dump(date('H:i:s'));
    }

}