<?php
/**
 * Created by PhpStorm.
 * User: stefa
 * Date: 07/05/2016
 * Time: 11:22
 */

namespace Dup\UserBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Dup\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class KeepOnline
{
    /**
     * @var User
     */
    private $user;
    private $em;
    public function __construct(TokenStorage $storage, EntityManagerInterface $em){
        if (null === $token = $storage->getToken()) {
            return;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }
        $this->user = $user;
        $this->em = $em;

    }

    public function onKernelController(){
        if(is_null($this->user)) return;
        $user = $this->user;
        $user->setLastActionDate(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();
    }
}
