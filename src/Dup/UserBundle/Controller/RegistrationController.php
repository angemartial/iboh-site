<?php

namespace Dup\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dup\UserBundle\Entity\User;
use Dup\UserBundle\Form\RegistrationFormType;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormError;

class RegistrationController extends Controller
{
    public function RegisterAction(Request $request)
    {
        $dispatcher = $this->get('event_dispatcher');
        $userManager = $this->get('fos_user.user_manager');
        $user = new User;
        $user->setEnabled(true);
        $form = $this->createForm(new RegistrationFormType, $user);
        $form->handleRequest($request);
        $url = $this->generateUrl('dup_dashboard_homepage');
        $response = new RedirectResponse($url);
        if($form->isValid()){
            $userManager->updateUser($user, true);
            $this->addFlash('success', 'Inscription reussie '.$user->getUsername().' !');
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $response;
        }
        if('POST' == $request->getMethod()){
            $errors = $form->getErrors(true, false);
            $this->addFlash('danger', 'Impossible de creer le compte :'.$this->iterateError($errors));
            return $response;
        }
        return $this->render('DupUserBundle:Registration:registrationForm.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    public  function iterateError($errors){
        $message = '';
        foreach ($errors as $error) {
            if  (! $error instanceof FormError){
                $message .= $this->iterateError($error);
            }else{
                $message .= '<li>'.$error->getMessage().'</li>';
            }  
        }
        return $message;
    }
}
 
