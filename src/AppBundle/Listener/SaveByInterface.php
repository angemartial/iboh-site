<?php
/**
 * Created by PhpStorm.
 * User: Stefann
 * Date: 01/09/2017
 * Time: 00:49
 */

namespace AppBundle\Listener;


use Dup\UserBundle\Entity\User;

interface SaveByInterface
{
    /**
     * @param User $savedBy
     */
    public function setSavedBy (User $savedBy );
}