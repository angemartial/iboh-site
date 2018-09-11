<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 10/08/2018
 * Time: 17:10
 */

namespace AppBundle\Extra;


use AppBundle\Entity\Location;

class PropertySearch
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @var string
     */
    private $subLocation;

    /**
     * @var int
     */
    private $minArea;

    /**
     * @var int
     */
    private $maxArea;

    /**
     * @var int
     */
    private $bedRooms;

    /**
     * @var int
     */
    private $bathRooms;

    /**
     * @var string
     */
    private $priceMin;


    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getSubLocation()
    {
        return $this->subLocation;
    }

    /**
     * @param string $subLocation
     */
    public function setSubLocation(string $subLocation)
    {
        $this->subLocation = $subLocation;
    }

    /**
     * @return int
     */
    public function getMinArea()
    {
        return $this->minArea;
    }

    /**
     * @param int $minArea
     */
    public function setMinArea(int $minArea)
    {
        $this->minArea = $minArea;
    }

    /**
     * @return int
     */
    public function getMaxArea()
    {
        return $this->maxArea;
    }

    /**
     * @param int $maxArea
     */
    public function setMaxArea(int $maxArea)
    {
        $this->maxArea = $maxArea;
    }

    /**
     * @return int
     */
    public function getBedRooms()
    {
        return $this->bedRooms;
    }

    /**
     * @param int $bedRooms
     */
    public function setBedRooms(int $bedRooms)
    {
        $this->bedRooms = $bedRooms;
    }

    /**
     * @return int
     */
    public function getBathRooms()
    {
        return $this->bathRooms;
    }

    /**
     * @param int $bathRooms
     */
    public function setBathRooms(int $bathRooms)
    {
        $this->bathRooms = $bathRooms;
    }



    /**
     * @return int
     */
    public function getPriceMax()
    {
        return $this->priceMax;
    }

    /**
     * @param int $priceMax
     */
    public function setPriceMax(int $priceMax)
    {
        $this->priceMax = $priceMax;
    }

    /**
     * @var int
     */
    private $priceMax;

    /**
     * @return string
     */
    public function getPriceMin()
    {
        return $this->priceMin;
    }

    /**
     * @param string $priceMin
     * @return PropertySearch
     */
    public function setPriceMin($priceMin)
    {
        $this->priceMin = $priceMin;

    }


}