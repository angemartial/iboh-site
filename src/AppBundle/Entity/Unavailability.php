<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Unavailability
 *
 * @ORM\Table(name="unavailability")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnavailabilityRepository")
 */
class Unavailability extends SuperClass
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
     * @var \DateTime
     *
     * @ORM\Column(name="begins", type="datetime")
     */
    private $begins;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ends", type="datetime", nullable=true)
     */
    private $ends;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="text")
     */
    private $reason;
    
    
    /**
     * @var UnavailabilityType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnavailabilityType")
     */
    private $type;
    
    /**
     * @var Rental
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Rental")
     */
    private $rental;
    
    /**
     * @return Rental
     */
    public function getRental ()
    {
        return $this -> rental;
    }
    
    /**
     * @param Rental $rental
     *
     * @return Unavailability
     */
    public function setRental ( $rental )
    {
        $this -> rental = $rental;
        
        return $this;
    }
    
    
    
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
     * Set begins
     *
     * @param \DateTime $begins
     *
     * @return Unavailability
     */
    public function setBegins($begins)
    {
        $this->begins = $begins;

        return $this;
    }

    /**
     * Get begins
     *
     * @return \DateTime
     */
    public function getBegins()
    {
        return $this->begins;
    }

    /**
     * Set ends
     *
     * @param \DateTime $ends
     *
     * @return Unavailability
     */
    public function setEnds($ends)
    {
        $this->ends = $ends;

        return $this;
    }

    /**
     * Get ends
     *
     * @return \DateTime
     */
    public function getEnds()
    {
        if(null === $this->ends){
            $this->ends = new \DateTime();
            $this->ends->add( new \DateInterval( 'P100Y'));
        }
        return $this->ends;
    }

    /**
     * Set reason
     *
     * @param string $reason
     *
     * @return Unavailability
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
    
    /**
     * @return UnavailabilityType
     */
    public function getType ()
    {
        return $this -> type;
    }
    
    /**
     * @param UnavailabilityType $type
     */
    public function setType ( $type )
    {
        $this -> type = $type;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function checkTypeAndRental(){
        $type = $this->type;
        $typeTitle = $type->getTitle();
        if($typeTitle !== 'Location' && null !== $this->rental){
            throw new ValidatorException('Une location est attachée à cette indisponibilité alors qu\'elle est de type '.$type);
        }
        if($typeTitle === 'Location' && null === $this->rental){
            throw new ValidatorException('Aucune location n\'est attachée à cette indisponibilité alors qu\'elle est de type '. $type);
        }
    }
    
    
}

