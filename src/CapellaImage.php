<?php

namespace Capella;

/**
 * Class CapellaImage
 * @package Capella
 *
 * Class to work with image filters.
 * Available filters:
 *  - resize (width, [height])
 *  - crop (width, [height, [top, left]])
 *  - pixelize (size)
 *
 * @property $id - image id
 * @property $url - image url
 *
 */
class CapellaImage
{
    public $id;
    public $url;

    private $filters = [];

    /**
     * CapellaImage constructor.
     * @param string $id - image id
     */
    public function __construct($id)
    {
        $config = $this->loadConfig();

        $this->id = $id;
        $this->url = $config['api_url'] . $id;
    }

    /**
     * Add resize filter to filters sequence
     *
     * @param int $width - with to resize
     * @param null|int $height - height to resize. If null, image'll be squared.
     * @return CapellaImage $this
     */
    public function resize($width, $height = null)
    {
        array_push($this->filters, [
            'name' => 'resize',
            'width' => $width,
            'height' => $height
        ]);

        return $this;
    }

    /**
     * Add crop filter to filters sequence
     *
     * If left or top parameters is null, image will be centred and cropped
     *
     * @param int $width - width to crop
     * @param null|int $height - height to crop, if null image'll be squared
     * @param null|int $left - x coordinate of top left corner
     * @param null|int $top - y coordinate of top left corner
     * @return CapellaImage $this
     */
    public function crop($width, $height = null, $left = null, $top = null)
    {
        array_push($this->filters, [
            'name' => 'crop',
            'width' => $width,
            'height' => $height,
            'left' => $left,
            'top' => $top
        ]);

        return $this;
    }

    /**
     * Add pixelize filter to filters sequence
     *
     * @param int $size - pixels number on longest side
     * @return CapellaImage $this
     */
    public function pixelize($size)
    {
        array_push($this->filters, [
            'name' => 'pixelize',
            'size' => $size
        ]);

        return $this;
    }

    /**
     * Clear filters sequence
     *
     * @return CapellaImage $this
     */
    public function clear()
    {
        $this->filters = [];

        return $this;
    }

    /**
     * Return url of image with applied filters
     *
     * @return string
     */
    public function url()
    {
        $filtersString = '';
        foreach ($this->filters as $filter) {

            switch ($filter['name']) {
                case 'resize':
                    $width = $filter['width'];
                    $height = $filter['height'];

                    $filtersString .= '/resize';

                    if (is_null($height)) {
                        $filtersString .= sprintf('/%d', $width);
                    } else {
                        $filtersString .= sprintf('/%dx%d', $width, $height);
                    }

                    break;

                case 'crop':
                    $width = $filter['width'];
                    $height = $filter['height'];
                    $left = $filter['left'];
                    $top = $filter['top'];

                    $filtersString .= '/crop';

                    if (is_null($height) && (is_null($top) || is_null($left))) {
                        $filtersString .= sprintf('/%d', $width);
                    } elseif (is_null($top) || is_null($left)) {
                        $filtersString .= sprintf('/%dx%d', $width, $height);
                    } else {
                        $filtersString .= sprintf('/%dx%d&%d,%d', $width, $height, $left, $top);
                    }

                    break;

                case 'pixelize':
                    $size = $filter['size'];

                    $filtersString .= sprintf('/pixelize/%d', $size);

                    break;

            }

        }

        $this->clear();
        return $this->url . $filtersString;
    }

    private function loadConfig()
    {
        return include 'config.php';
    }

}