<?php
/**
 * Created by PhpStorm.
 * User: stefa
 * Date: 12/01/2017
 * Time: 11:00
 */

namespace Dup\UserBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dup\UserBundle\Entity\Privilege;
use Dup\UserBundle\Entity\Role;
use Dup\UserBundle\Entity\User;

class RoleManager
{

    const PAID_ROLE_CODE = 'ROLE_BASIC';
    
    public function isAnonymous(User $user){
        return $user->getUsername() === 'anon';
    }

    public function filterByPrivilege(Privilege $privilege, ArrayCollection $users){
        $filtered = [];
        foreach ($users as $user) {
            if($this->canDo($privilege, $user)){
                $filtered[] = $user;
            }
        }
        return new ArrayCollection($filtered);
    }

    /**
     * @param array|ArrayCollection      $privileges
     * @param User $user
     *
     * @return bool
     */
    public function canDoAll($privileges, User $user){
        /**
         * @var Privilege $privilege
         */
        foreach ( $privileges as $privilege ) {
            if(false === $this->canDo( $privilege, $user)){
                return false;
            }
        }
        return true;
    }

    public function canDo(Privilege $privilege, User $user){
        $roles = $privilege->getRoles();
        foreach ($roles as $role) {
            if($this->isGranted($role->getCode(), $user)){
                return true;
            }
        }
        return false;
    }

    public function isGranted($role, User $user){
        $roles = $user->getEntityRoles()->toArray();
        $all = $this->getSubRoles($roles);
        $codes = array_map(function ($role){
            /**@var Role $role */
            return $role->getCode();
        }, $all);
        return in_array($role, $codes);
    }
    
    public function postLoad($entity, LifecycleEventArgs $args){
        if(method_exists( $entity, 'getPrivileges')){
            $privileges = $entity->getPrivileges();
            $isFree = true;
            /** @var Privilege $privilege */
            foreach ( $privileges as $privilege ) {
                $subRoles = $this->getSubRoles( $privilege->getRoles()->toArray());
                /** @var Role $role */
                foreach ( $subRoles as $role ) {
                    if($role->getCode() === self::PAID_ROLE_CODE){
                        $isFree = false;
                        break 2;
                    }
                }
            }
            $entity->setFree($isFree);
        }
    }

    public function getSubRoles($roles){
        $fullSubRoles = $roles;
        /** @var Role $role */
        foreach ($roles as $role) {
            $singleSubRoles = $role->getSubRoles()->toArray();
            if(!empty($singleSubRoles)) $fullSubRoles = array_merge($fullSubRoles, $this->getSubRoles($singleSubRoles));
        }
        return array_unique($fullSubRoles);
    }
}
