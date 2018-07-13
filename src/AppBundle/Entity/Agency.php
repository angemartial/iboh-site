<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 11:48
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Agency
 * @package Iboh\Model
 *
 * @ORM\Table(name="agency")
 * @ORM\Entity()
 */
class Agency
{
    /**
     * @var int Primary key of the table
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255)
     *
     */
    private $address2;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50)
     */
    private $phone;


    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=5)
     */
    private $zip;

    /**
     * @var string
     * @ORM\Column(name="website", type="string", length=255)
     */
    private $website;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Agency
     */
    public function setId(int $id): Agency
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Agency
     */
    public function setTitle(string $title): Agency
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Agency
     */
    public function setDescription(string $description): Agency
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     * @return Agency
     */
    public function setAddress1(string $address1): Agency
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     * @return Agency
     */
    public function setAddress2(string $address2): Agency
    {
        $this->address2 = $address2;
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
     * @return Agency
     */
    public function setEmail(string $email): Agency
    {
        $this->email = $email;
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
     * @return Agency
     */
    public function setPhone(string $phone): Agency
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return Agency
     */
    public function setZip(string $zip): Agency
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Agency
     */
    public function setWebsite(string $website): Agency
    {
        $this->website = $website;
        return $this;
    }


}