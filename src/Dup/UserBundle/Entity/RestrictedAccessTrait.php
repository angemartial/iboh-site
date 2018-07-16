<?php
/**
 * Created by PhpStorm.
 * User: stefa
 * Date: 22/05/2017
 * Time: 16:21
 */

namespace Dup\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait RestrictedAccessTrait {
    /**
     * @var ArrayCollection Privilege
     *
     * @ORM\ManyToMany(targetEntity="Dup\UserBundle\Entity\Privilege")
     */
    private $privileges;
    
    /**
     * @var bool
     */
    private $free;
    
    /**
     * @return bool
     */
    public function isFree ()
    {
        return $this -> free;
    }
    
    /**
     * @param bool $free
     *
     * @return RestrictedAccessTrait
     */
    public function setFree ( $free )
    {
        $this -> free = $free;
        
        return $this;
    }

    public function getPrivileges(){
        return $this->privileges;
    }

    /**
     * Add privilege
     *
     * @param Privilege $privilege
     *
     * @return $this
     */
    public function addPrivilege(Privilege $privilege){
        $this->privileges->add( $privilege);

        return $this;
    }

    /**
     * @param Privilege $privilege
     *
     * @return $this
     */
    public function removePrivilege(Privilege $privilege){
        $this->privileges->removeElement( $privilege);

        return $this;
    }

}
