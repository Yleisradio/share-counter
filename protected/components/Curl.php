<?php

/**
 * Wrapper for PHP Curl
 * 
 */
class Curl
{

    protected static function getDefaultOptions()
    {
        $options = array(
            'log' => null,
            'urlEncode' => true,
            'httpProxy' => null,
            'timeout' => 5,
            'connectTimeout' => 0,
        );
        if (isset(Yii::app()->params['httpProxy'])) {
            $options['httpProxy'] = Yii::app()->params['httpProxy']['host'] . ':' . Yii::app()->params['httpProxy']['port'];
        }
        return $options;
    }

    /**
     * Performs a get request
     * @param type $url
     * @param type $data
     * @param type $options
     * @return type
     */
    public static function get($url, $data = array(), $options = array())
    {
        $options = array_merge(self::getDefaultOptions(), $options);
        $curl = self::init($options);
        $request = self::constructGetQuery($url, $data, $options);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,
        ));
        $response = self::request($curl, $options);
        return $response;
    }

    /**
     * Performs a post request
     * @param type $url
     * @param type $data
     * @return type
     */
    public static function post($url, $data = array(), $options = array())
    {
        $options = array_merge(self::getDefaultOptions(), $options);
        $curl = self::init($options);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        $response = self::request($curl, $options);
        return $response;
    }

    /**
     * Initializes Curl
     * @return type
     */
    protected static function init($options)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'YLE Kato ite',
            CURLINFO_HEADER_OUT => true,
            CURLOPT_CONNECTTIMEOUT => $options['connectTimeout'],
            CURLOPT_TIMEOUT => $options['timeout'],
        ));
        if ($options['httpProxy'])
            curl_setopt($curl, CURLOPT_PROXY, $options['httpProxy']);

        return $curl;
    }

    /**
     * Performs the curl request and logs it.
     * @param type $curl
     * @return type
     */
    protected static function request($curl, $options)
    {
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        if (isset($info['request_header'])) {
            Apilog::log($info['request_header'], $response, $info['http_code'], $info['total_time'], $options['log']);
        }
        curl_close($curl);
        return $response;
    }

    /**
     * Constructs a query string with url and parameters
     * @param type $url
     * @param type $parameters
     * @return string
     */
    protected static function constructGetQuery($url, $parameters, $options = array())
    {
        if ($parameters) {
            $queryString = array();
            foreach ($parameters as $key => $value) {
                if ($options['urlEncode']) {
                    $value = urlencode($value);
                }
                $queryString[] = $key . '=' . $value;
            }
            $queryString = implode('&', $queryString);
            if (strpos($url, '?') === true)
                $url .= '&' . $queryString;
            else
                $url .= '?' . $queryString;
        }
        return $url;
    }

}