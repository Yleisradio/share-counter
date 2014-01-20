<?php

class FacebookUpdater
{

    /**
     * Updates all Facebook metrics with one request.
     * @param type $siteId
     * @param type $url
     * @return type
     */
    public static function updateFacebook($siteId, $url)
    {
        $facebookData = Curl::get('https://api.facebook.com/method/fql.query?format=json&query=SELECT+share_count,+like_count,+comment_count,+total_count+FROM+link_stat+WHERE+url=%22' . $url . '%22');
        $facebookData = json_decode($facebookData, true);
        if (isset($facebookData[0])) {
            $facebookData = $facebookData[0];
            $facebookShare = new FacebookShare();
            $facebookShare->site_id = $siteId;
            $facebookShare->updateMetric($facebookData['share_count']);
            $facebookLike = new FacebookLike();
            $facebookLike->site_id = $siteId;
            $facebookLike->updateMetric($facebookData['like_count']);
            $facebookComment = new FacebookComment();
            $facebookComment->site_id = $siteId;
            $facebookComment->updateMetric($facebookData['comment_count']);
            return $facebookData;
        } else {
            Yii::log(print_r($facebookData, true), 'info');
        }
    }

}
