<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnavailabilityType
 *
 * @ORM\Table(name="unavailability_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnavailabilityTypeRepository")
 */
class UnavailabilityType extends SuperClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $color;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getColor ()
    {
        return $this -> color;
    }
    
    /**
     * @param string $color
     *
     * @return UnavailabilityType
     */
    public function setColor ( $color )
    {
        $this -> color = $color;
        
        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return UnavailabilityType
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    public function __toString ()
    {
        return $this->title;
    }
}

