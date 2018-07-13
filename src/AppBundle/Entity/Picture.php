<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 13:35
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Picture
 * @package Iboh\Model
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity()
 */
class Picture
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
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;


    /**
     * @var Property
     * @ORM\ManyToOne(targetEntity="Property")
     */
    private $property;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Picture
     */
    public function setId(int $id): Picture
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Picture
     */
    public function setLink(string $link): Picture
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     * @param Property $property
     * @return Picture
     */
    public function setProperty(Property $property): Picture
    {
        $this->property = $property;
        return $this;
    }


}