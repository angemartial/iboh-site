<?php

namespace Dup\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dup\UserBundle\Entity\User;

/**
 * This deals with the menu options of the admin dashboard user list
 */
class AdminController extends Controller
{
    /**
     * Used to manage the user's access rights in the application
     * 
     * @param  User   $user The user
     * @param  string $type promote or demote a user ? what role to add or to remove ?
     * 
     * @return RedirectResponse or NotFoundException
     */
    public function promoteAction(User $user, $type)
    {
        $em = $this->getDoctrine()->getManager();
        switch ($type) {
            case 'super-admin':
                if($this->isGranted('ROLE_SUPER_ADMIN'))
                    $user->setSuperAdmin(true);
                else{
                    $this->denyAccess();
                }
                break;

            case 'admin':
                if($this->isGranted('ROLE_SUPER_ADMIN')){
                    $user->setSuperAdmin(false);
                    $user->addRole('ROLE_ADMIN');
                }else{
                    $this->denyAccess();
                }   
                break;

            case 'non-published':
                if($this->isGranted('ROLE_ADMIN')){
                    $user->addRole('CAN_VIEW_NON_PUBLISHED');
                }else{
                    $this->denyAccess();
                }  
                break;

            case 'user':
                if($this->isGranted('ROLE_SUPER_ADMIN') || ($this->isGranted('ROLE_ADMIN') && !$user->isSuperAdmin() && !$user->hasRole('ROLE_ADMIN'))){
                    $user->setRoles(array('ROLE_USER'));
                }else{
                    $this->denyAccess();
                } 
                break;
            
            default:
                return $this->createNotFoundException('Cette option est indéfinie. Contactez l\'administrateur pour plus de détails');
                break;
        }
        $em->persist($user);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_dup_user_user_edit' , array('id' => $user->getId())));
    }

    private function denyAccess(){
        $this->addFlash('error', 'Vous n\'êtes pas autorisé à effectuer cette action sur cet utilisateur !');
    }
}
