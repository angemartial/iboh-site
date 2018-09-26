<?php
/**
 * Created by PhpStorm.
 * User: Stefann
 * Date: 01/09/2017
 * Time: 00:36
 */

namespace AppBundle\Entity;


use Dup\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

trait SaveByTrait
{
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Dup\UserBundle\Entity\User")
     */
    private $savedBy;
    
    /**
     * @return User
     */
    public function getSavedBy ()
    {
        return $this -> savedBy;
    }
    
    /**
     * @param User $savedBy
     *
     * @return SaveByTrait
     */
    public function setSavedBy (User $savedBy )
    {
        $this -> savedBy = $savedBy;
        
        return $this;
    }
    
    
    
    
    
}