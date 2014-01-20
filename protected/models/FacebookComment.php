<?php

class FacebookComment extends Metric
{

    protected static $_type = 3;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
}