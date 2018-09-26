<?php
/**
 * Created by PhpStorm.
 * User: kangem
 * Date: 25/09/2019

 */

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait Availability
{
    /**
     * @var boolean
     */
    private $available = true;
    
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Unavailability")
     */
    private $unavailabilities;
    
    /**
     * @return ArrayCollection
     */
    public function getUnavailabilities(){
        if(null === $this->unavailabilities){
            $this->unavailabilities = new ArrayCollection();
        }
        return $this->unavailabilities;
    }
    
    /**
     * @param Unavailability $unavailability
     *
     * @throws CrossUnavailabilityException if an unavailability already exist through the given period
     */
    public function addUnavailability(Unavailability $unavailability){
        if($this->checkAvailabilityByPeriod( $unavailability -> getBegins (), $unavailability->getEnds())){
            $this->unavailabilities->add( $unavailability);
            return;
        }
        throw new CrossUnavailabilityException('Impossible d\'enregistrer l\'élément, une indisponibilité existe déjà sur tout ou partie de la periode renseignée');
    }
    
    /**
     * @param Unavailability $unavailability
     */
    public function removeUnavailability(Unavailability $unavailability){
        $this->unavailabilities->removeElement( $unavailability);
    }
    
    /**
     * @param \DateTime $begin
     * @param \DateTime $end
     *
     * @return bool
     */
    public function checkAvailabilityByPeriod(\DateTime $begin, \DateTime $end){
        $bTimestamp = $begin->getTimestamp();
        $eTimestamp = $end->getTimestamp();
        $unavailabilities = $this->getUnavailabilities();
        /** @var Unavailability $unavailability */
        foreach ( $unavailabilities as $unavailability ) {
            $isAvailable = $bTimestamp > $unavailability->getEnds()->getTimestamp() || $eTimestamp < $unavailability->getBegins()->getTimestamp();
            if(!$isAvailable){
                return false;
            }
        }
        return true;
    }
    
    public function findUnavailabilityByDate(\DateTime $date = null){
        if(null === $date){
            $date = new \DateTime();
        }
        $unavailabilities = $this->getUnavailabilities();
        $timestamp = $date->getTimestamp();
        /** @var Unavailability $unavailability */
        foreach ( $unavailabilities as $unavailability ) {
            if($timestamp > $unavailability->getBegins()->getTimestamp() && $timestamp < $unavailability->getEnds()->getTimestamp()){
                return $unavailability;
            }
        }
        return null;
    }
    
    /**
     * @param \DateTime|null $date
     *
     * @return bool
     */
    public function checkAvailabilityByDate(\DateTime $date = null){
        $unavailability = $this->findUnavailabilityByDate($date);
        return null === $unavailability;
    }
    
    /**
     * @return bool
     */
    public function isAvailable ()
    {
        return $this -> available;
    }
    
    /**
     * @param bool $available
     *
     * @return Availability
     */
    public function setAvailable ( $available )
    {
        $this -> available = $available;
        
        return $this;
    }
    
    /**
     * @return bool
     * @ORM\PostLoad()
     */
    public function initializeAvailabilityForToday(){
        $this->setAvailable( $this->checkAvailabilityByDate());
    }
    
    public function sortUnavailabilitiesByDate(){
        $unavailabilities = $this->unavailabilities->toArray();
        if(null === $unavailabilities){
            return null;
        }
        
        usort( $unavailabilities, function ($a, $b) {
            /** @var Unavailability $a
             * @var Unavailability $b
             */
            $aTimestamp = $a->getBegins()->getTimestamp();
            $bTimestamp = $b->getBegins()->getTimestamp();
            if($aTimestamp === $bTimestamp){
                return 0;
            }
            return $aTimestamp > $bTimestamp ? 1 : -1;
        });
        return new ArrayCollection($unavailabilities);
        
    }
}