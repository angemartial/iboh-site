<?php
/**
 * Created by PhpStorm.
 * User: Stefann
 * Date: 01/09/2017
 * Time: 00:44
 */

namespace AppBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SaveByListener
{
    private $container;
    
    public function __construct (ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }
        
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }
        
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }
        
        return $user;
    }
    
    public function prePersist(SaveByInterface $entity){
        $user = $this->getUser();
        $entity->setSavedBy( $user);
    }
}