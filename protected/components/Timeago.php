<?php

/**
 * Wrapper for timeago.js
 */
class Timeago
{

    /**
     * Prints unknown or a unix epoch timestamp in a format suitable for jQuery timeago component.
     * @param type $timestamp
     * @return string
     */
    public static function timeagoOrUnknown($timestamp)
    {
        if (!$timestamp) {
            return 'Ei tiedossa';
        } else {
            return CHtml::tag("abbr", array("class" => "timeago", "title" => date("r", $timestamp)), date("d.m.Y H:i", $timestamp));
        }
    }

}