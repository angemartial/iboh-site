<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 14:27
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 * @package Iboh\Model
 *
 * @ORM\Table(name="address")
 * @ORM\Entity()
 */
class Address
{
    /**
     * @var int Primary key of table
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue()
     *
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=50)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="district", type="string")
     */
    private $district;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="pob", type="string", length=255)
     */
    private $pob;

    /**
     * @var Agency
     * @ORM\ManyToOne(targetEntity="Agency")
     */
    private $agency;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location")
     */
    private $location;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Address
     */
    public function setId(int $id): Address
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Address
     */
    public function setPhone(string $phone): Address
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @param string $district
     * @return Address
     */
    public function setDistrict(string $district): Address
    {
        $this->district = $district;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Address
     */
    public function setEmail(string $email): Address
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPob(): string
    {
        return $this->pob;
    }

    /**
     * @param string $pob
     * @return Address
     */
    public function setPob(string $pob): Address
    {
        $this->pob = $pob;
        return $this;
    }

    /**
     * @return Agency
     */
    public function getAgency(): Agency
    {
        return $this->agency;
    }

    /**
     * @param Agency $agency
     * @return Address
     */
    public function setAgency(Agency $agency): Address
    {
        $this->agency = $agency;
        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     * @return Address
     */
    public function setLocation(Location $location): Address
    {
        $this->location = $location;
        return $this;
    }


}