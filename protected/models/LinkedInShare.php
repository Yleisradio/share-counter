<?php

class LinkedInShare extends Metric
{

    protected static $_type = 5;

    public function fetchValue()
    {
        $response = Curl::get('http://www.linkedin.com/countserv/count/share?url=' . $this->site->url . '&format=json');
        $response = json_decode($response, true);
        if (isset($response['count']))
            return $response['count'];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}