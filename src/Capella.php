<?php

namespace Capella;


/**
 * Class Uploader
 * @package Capella
 *
 * PHP SDK for CodeX Capella
 *
 * @example
 * $capella = new \Capella\Uploader();
 *
 * $response = $capella->upload($pathToImg);
 *
 */
class Uploader
{

    protected $API_URL;

    public function __construct() {
        $config = $this->loadConfig();

        $this->API_URL = $config['api_url'];
    }

    /**
     * Upload image to capella service
     *
     * @param string $path - path or url to image
     * @return mixed
     */
    public function upload($path) {

        $url = $this->API_URL;

        if (file_exists($path)) {
            /** Path is local file */

            $fileContext = curl_file_create($path);
            return $this->sendRequest($url, ['file' => $fileContext]);

        } else {
            /** Path is url */

            return $this->sendRequest($url, ['link' => $path]);

        }

    }

    /**
     *
     * Send cURL request to capella service
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return mixed
     * @throws \Exception
     *
     */
    protected function sendRequest($url, array $params, $method='POST') {

        $curl = curl_init();

        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST,1);

                if (count($params)) {
                    curl_setopt($curl,CURLOPT_POSTFIELDS, $params);
                }

                break;

            case 'GET':
                if (!count($params)) {
                    break;
                }

                $query = '';
                foreach ($params as $key => $value) {
                    $query .= $key . '=' . urlencode($value) . '&';
                }

                $query = trim($query, '&');

                $url .= '?' . $query;
                break;

            default:
                throw new \Exception('Unsupported method');
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;

    }

    protected function loadConfig() {
        return include 'config.php';
    }

}