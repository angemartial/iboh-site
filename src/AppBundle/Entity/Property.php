<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 13:00
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Property
 * @package Iboh\Model
 *
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyRepository")
 */
class Property
{

    use Availability;

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="sub_location", type="string", length=255)
     */
    private $subLocation;

    /**
     * @return bool
     */
    public function isFurnished(): bool
    {
        return $this->furnished;
    }

    /**
     * @param bool $furnished
     * @return Property
     */
    public function setFurnished(bool $furnished)
    {
        $this->furnished = $furnished;
        return $this;
    }

    /**
     * @var boolean
     * @ORM\Column(name="furnished", type="boolean")
     */
    private $furnished;


    /**
     * @var integer
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var integer
     * @ORM\Column(name="living_space", type="integer")
     */
    private $livingSpace;

    /**
     * @var int
     * @ORM\Column(name="field_space", type="integer")
     */
    private $fieldSpace;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="array", nullable=true)
     */
    private $images;

    /**
     * @var integer
     * @ORM\Column(name="bedroom", type="integer")
     */
    private $bedroom;

    /**
     * @var integer
     * @ORM\Column(name="bathroom", type="integer")
     */
    private $bathroom;

    /**
     * @var integer
     * @ORM\Column(name="kitchen", type="integer")
     */
    private $kitchen;

    /**
     * @var bool
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = false;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     */
    private $location;

    /**
     * @var Sale
     *
     * @ORM\OneToOne(targetEntity="Sale")
     */
    private $sale;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     */
    private $type;

    /**
     * @var Rental
     * @ORM\OneToOne(targetEntity="Rental")
     */
    private $rental;

    /**
     * @var Convenience[]
     *
     * @ORM\ManyToMany(targetEntity="Convenience")
     */
    private $conveniences;


    public function __construct()
    {
        $this->conveniences = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Property
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Property
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Property
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Property
     */
    public function setYear(int $year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return int
     */
    public function getLivingSpace()
    {
        return $this->livingSpace;
    }

    /**
     * @param int $livingSpace
     * @return Property
     */
    public function setLivingSpace(int $livingSpace)
    {
        $this->livingSpace = $livingSpace;
        return $this;
    }

    /**
     * @return int
     */
    public function getFieldSpace()
    {
        return $this->fieldSpace;
    }

    /**
     * @param int $fieldSpace
     * @return Property
     */
    public function setFieldSpace(int $fieldSpace)
    {
        $this->fieldSpace = $fieldSpace;
        return $this;
    }

    /**
     * @return int
     */
    public function getBedroom()
    {
        return $this->bedroom;
    }

    /**
     * @param int $bedroom
     * @return Property
     */
    public function setBedroom(int $bedroom)
    {
        $this->bedroom = $bedroom;
        return $this;
    }

    /**
     * @return int
     */
    public function getBathroom()
    {
        return $this->bathroom;
    }

    /**
     * @param int $bathroom
     * @return Property
     */
    public function setBathroom(int $bathroom)
    {
        $this->bathroom = $bathroom;
        return $this;
    }

    /**
     * @return int
     */
    public function getKitchen()
    {
        return $this->kitchen;
    }

    /**
     * @param int $kitchen
     * @return Property
     */
    public function setKitchen(int $kitchen)
    {
        $this->kitchen = $kitchen;
        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     * @return Property
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Sale|null
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * @param Sale $sale
     * @return Property
     */
    public function setSale(Sale $sale)
    {
        $this->sale = $sale;
        return $this;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return Property
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Rental|null
     */
    public function getRental()
    {
        return $this->rental;
    }

    /**
     * @param Rental $rental
     * @return Property
     */
    public function setRental(Rental $rental)
    {
        $this->rental = $rental;
        return $this;
    }

    /**
     * @return Convenience[]
     */
    public function getConveniences()
    {
        return $this->conveniences;
    }

    /**
     * @param Convenience $convenience
     * @return Property
     */
    public function addConvenience(Convenience $convenience)
    {
        $this->conveniences[] = $convenience;

        return $this;
    }

    /**
     * @param Convenience $convenience
     * @return Property
     */
    public function removeConvenience(Convenience $convenience)
    {
        $this->conveniences->removeElement($convenience);

        return $this;
    }

    /**
     * @return string
     */
    public function getSubLocation(): string
    {
        return $this->subLocation;
    }

    /**
     * @param string $subLocation
     * @return Property
     */
    public function setSubLocation(string $subLocation)
    {
        $this->subLocation = $subLocation;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return $this|Property
     */
    public function setImages(array $images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return Property
     */
    public function setPublished(bool $published)
    {
        $this->published = $published;
        return $this;
    }




}