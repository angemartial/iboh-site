<?php
/**
 * Created by PhpStorm.
 * User: Stefann
 * Date: 29/06/2017
 * Time: 12:52
 */

namespace Dup\UserBundle\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dup\UserBundle\Entity\User;
use Dup\UserBundle\Entity\UserParameter;

class UserParamSetterListener
{
    protected $em;
    
    protected $defaults;
    
    public function __construct (EntityManager $em)
    {
        $this->em = $em;
        $this->defaults = [
            'chat' => '1',
            'chrono' => '1',
            'battle' => '1'
        ];
    }
    
    /**
     * @param                    $entity
     * @param LifecycleEventArgs $event
     */
    public function postPersist($entity, LifecycleEventArgs $event){
        if($entity instanceof User){
            foreach ( $this -> defaults as $parameter => $value ) {
                $userParameter = new UserParameter();
                $userParameter->setUser( $entity);
                $userParameter->setTitle( $parameter);
                $userParameter->setValue( $value);
                $this->em->persist( $userParameter);
            }
            $this->em->flush();
        }
    }
}