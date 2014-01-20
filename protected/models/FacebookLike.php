<?php

class FacebookLike extends Metric
{

    protected static $_type = 2;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}