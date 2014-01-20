<?php

class Tweet extends Metric
{

    protected static $_type = 4;

    public function fetchValue()
    {
        $response = Curl::get('http://cdn.api.twitter.com/1/urls/count.json?url=' . $this->site->url);
        $response = json_decode($response, true);
        if (isset($response['count']))
            return $response['count'];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}