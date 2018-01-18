<?php

namespace Capella;


/**
 * Class Uploader
 * @package Capella
 *
 * Provide image uploading to Capella service
 *
 */
class Uploader
{
    private $API_URL;

    /**
     * Uploader constructor.
     */
    public function __construct()
    {
        $config = $this->loadConfig();

        $this->API_URL = $config['api_url'] . 'upload';
    }

    /**
     * Upload image to capella service
     *
     * @param string $path - path or url to image
     * @return false|\stdClass – array if path is valid and capella.pics is accessible or false
     */
    public function upload($path)
    {
        $url = $this->API_URL;

        if (file_exists($path)) {
            /** Path is local file */

            $fileContext = curl_file_create($path);
            return @json_decode($this->sendRequest($url, ['file' => $fileContext]));

        } elseif ($this->isUrlValid($path)) {
            /** Path is url */

            return @json_decode($this->sendRequest($url, ['link' => $path]));

        }

        return false;
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
    private function sendRequest($url, array $params = [], $method = 'POST')
    {
        $curl = curl_init();
        $params = http_build_query($params);

        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST,1);

                if (!empty($params)) {
                    curl_setopt($curl,CURLOPT_POSTFIELDS, $params);
                }

                break;

            case 'GET':
                if (empty($params)) {
                    break;
                }

                $url .= '?' . $params;
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

    /**
     * Check if url is valid and accessible
     *
     * @param string $url
     * @return bool
     */
    private function isUrlValid($url)
    {
        if(!$url || !is_string($url)){
            return false;
        }

        if(!preg_match('/^http(s)?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)) {
            return false;
        }

        if($this->getHttpCode($url) != 200){
            return false;
        }

        return true;
    }

    /**
     * Get url HTTP code
     *
     * @param string $url
     * @return bool|number
     */
    private function getHttpCode($url)
    {
        $curl = @curl_init($url);

        if ($curl === false) {
            return false;
        }

        curl_setopt($curl, CURLOPT_HEADER,true);
        curl_setopt($curl, CURLOPT_NOBODY,true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

        curl_exec($curl);

        if (curl_errno($curl)) {
            curl_close($curl);
            return false;
        }

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $code;
    }

    private function loadConfig()
    {
        return include 'config.php';
    }
}