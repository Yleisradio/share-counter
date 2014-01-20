<?php

/**
 * Wrapper for ComScore Digital Analytix
 */
class DigitalAnalytix {

    private static $baseUrl = 'https://dax-rest.comscore.eu/v1/reportitems.json';

    /**
     * Get attributes from ComScore Digital Analytix and return them in array.
     * @param type $options
     * @param type $cache
     * @return type
     */
    public static function getReport($options, $cache = true) {


        $options['client'] = Yii::app()->params['dax']['client'];
        $options['user'] = Yii::app()->params['dax']['user'];
        $options['password'] = Yii::app()->params['dax']['password'];

        //checks if the attributes are empty
        if (empty($options['site'])) {
            $options['site'] = 'supersite';
        }
        if (empty($options['eventFilterId'])) {
            unset($options['eventFilterId']);
        }
        if (empty($options['visitFilterId'])) {
            unset($options['visitFilterId']);
        }
        if (empty($options['parameters'])) {
            unset($options['parameters']);
        }
        if (isset($options['parameters'])) {
            $encodedParameters = array();
            foreach ($options['parameters'] as $key => $value) {
                $encodedParameters[] = urlencode($key) . ':' . urlencode($value);
            }
            $encodedParameters = implode('|', $encodedParameters);
            $options['parameters'] = $encodedParameters;
        }
        //change array's letters to lowercase.
        $options = array_change_key_case($options, CASE_LOWER);

        $cacheId = implode('_', $options);
        $response = Yii::app()->cache->get($cacheId);
        if (!$response) {
            $response = Curl::get(self::$baseUrl, $options, array('timeout' => 4 * 60, 'urlEncode' => false));
            $response = json_decode($response, true);
            if (isset($response['ERROR'])) {
                
            } else if($cache) {
                Yii::app()->cache->set($cacheId, $response, 60 * 60);
            }
        }

        return $response;
    }

}