<?php

/**
 * API Wrapper in JSON format for Laravel
 *
 * @version 0.0.3
 * @package Laravel
 * @author Hendy Yanuar <hendy.yanuar@gmail.com>
 **/
class XApi
{
    public static function response($data = array('error' => 0, 'results' => null, 'message' => null), $http_code = 200)
    {
        return Response::json(
            array(
                'error' =>   $data['error'],
                'message' => empty($data['message']) ? null : $data['message'],
                'results' => empty($data['results']) ? null : $data['results']
            ),
            $http_code
        );
    }

    public static function parser($datas, $error = 0, $numeric_check = true)
    {
        $results = array();
        $results['count'] = count($datas);
        $results['data'] = ($numeric_check) ? json_decode(json_encode($datas, JSON_NUMERIC_CHECK)) : $datas;

        return XApi::response(array(
                'results' => $results,
                'error' => $error
            ));
    }
} // END class XApi