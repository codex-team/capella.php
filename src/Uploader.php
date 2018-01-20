<?php

namespace Capella;


/**
 * Class Uploader
 * @package Capella
 *
 * Provide image uploading to the Capella service
 *
 * @link https://github.com/codex-team/capella.php/wiki/%5CCapella%5CUploader
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
     * Upload image to the Capella service
     *
     * @param string $path - path or url to image
     * @return \stdClass – array if path is valid and Capella is accessible otherwise false
     * @throws CapellaException
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

        throw new CapellaException('Provided path links to the nonexistent/invalid file or inaccessible URL');
    }

    /**
     *
     * Send cURL request
     *
     * @param string $url - requested URL
     * @param array $params - request params
     * @param string $method - request method. Can be GET or POST
     * @return mixed
     * @throws \Exception
     *
     */
    private function sendRequest($url, array $params = [], $method = 'POST')
    {
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

                $params = http_build_query($params);
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
     * Check if URL is valid and accessible
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
     * Get URL HTTP code
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