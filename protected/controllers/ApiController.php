<?php

/**
 * Controller which returns data as JSON
 */
class ApiController extends Controller
{

    /**
     * Converts numeric variables to integers, encodes and outputs them as json.
     * @param type $output
     */
    public function output($output)
    {
        $this->toInteger($output);
        header('Content-Type: application/json');
        echo CJSON::encode($output);
    }

    /**
     * Converts numeric variables to integers.
     * @param type $array
     */
    protected function toInteger(&$array)
    {
        foreach ($array as &$value) {
            if (is_array($value))
                $this->toInteger($value);
            if (is_numeric($value)) {
                $value = (int) $value;
            }
        }
    }

    /**
     * Returns social data from the database.
     * Includes total sums and time series.
     * @param type $url
     * @param type $from
     * @param type $to
     */
    public function actionSocial($url, $from = null, $to = null)
    {
        $site = Site::model()->findByAttributes(array('url' => $url));
        $comments = FacebookComment::findAllBySiteId($site->id, $from, $to);
        $likes = FacebookLike::findAllBySiteId($site->id, $from, $to);
        $facebookShares = FacebookShare::findAllBySiteId($site->id, $from, $to);
        $tweets = Tweet::findAllBySiteId($site->id, $from, $to);
        $linkedInShares = LinkedInShare::findAllBySiteId($site->id, $from, $to);
        $sharesPerHours = SharesPerHour::findAllBySiteId($site->id, $from, $to);

        $facebookTotal = array();
        $sharesTotal = array();
        $commentsArray = array();
        $i = 0;
        foreach ($comments as $comment) {
            $commentsArray[] = $comment->toArray();
            $facebookTotal[$i] = array('timestamp' => $comment->timestamp, 'value' => $comment->value);
            $i++;
        }
        $likesArray = array();
        $i = 0;
        foreach ($likes as $like) {
            $likesArray[] = $like->toArray();
            $facebookTotal[$i]['value'] += $like->value;
            $i++;
        }
        $facebookSharesArray = array();
        $i = 0;
        foreach ($facebookShares as $share) {
            $facebookSharesArray[] = $share->toArray();
            $facebookTotal[$i]['value'] += $share->value;
            $sharesTotal[$i] = array('timestamp' => $share->timestamp, 'value' => $share->value);
            $i++;
        }

        $tweetsArray = array();
        $i = 0;
        foreach ($tweets as $tweet) {
            $tweetsArray[] = $tweet->toArray();
            if (isset($sharesTotal[$i]))
                $sharesTotal[$i]['value'] += $tweet->value;
            $i++;
        }
        $linkedInSharesArray = array();
        $i = 0;
        foreach ($linkedInShares as $linkedInShare) {
            $linkedInSharesArray[] = $linkedInShare->toArray();
            if (isset($sharesTotal[$i]))
                $sharesTotal[$i]['value'] += $linkedInShare->value;
            $i++;
        }
        $sharesPerHoursArray = array();
        $i = 0;
        foreach ($sharesPerHours as $sharesPerHour) {
            $sharesPerHoursArray[] = $sharesPerHour->toArray();
            $i++;
        }

        $output = array(
            'facebook' => array(
                'comments' => array(
                    'series' => $commentsArray,
                    'current' => $this->getCurrent($commentsArray),
                ),
                'likes' => array(
                    'series' => $likesArray,
                    'current' => $this->getCurrent($likesArray),
                ),
                'shares' => array(
                    'series' => $facebookSharesArray,
                    'current' => $this->getCurrent($facebookSharesArray),
                ),
                'total' => array(
                    'series' => $facebookTotal,
                    'current' => $this->getCurrent($facebookTotal),
                ),
            ),
            'twitter' => array(
                'tweets' => array(
                    'series' => $tweetsArray,
                    'current' => $this->getCurrent($tweetsArray),
                ),
            ),
            'linkedin' => array(
                'shares' => array(
                    'series' => $linkedInSharesArray,
                    'current' => $this->getCurrent($linkedInSharesArray),
                )
            ),
            'shares_per_hour' => array(
                'series' => $sharesPerHoursArray,
                'current' => $this->getCurrent($sharesPerHoursArray),
            ),
            'shares_total' => array(
                'series' => $sharesTotal,
                'current' => $this->getCurrent($sharesTotal),
            ),
        );
        $this->output($output);
    }

    /**
     * Returns the last value of a string key called value of an array.
     * @param type $array
     * @return string
     */
    protected function getCurrent($array)
    {
        if (count($array)) {
            $current = $array[count($array) - 1]['value'];
        } else {
            $current = '';
        }
        return $current;
    }

}