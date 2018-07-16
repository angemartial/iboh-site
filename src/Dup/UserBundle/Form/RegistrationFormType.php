<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dup\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', 
                array(
                    'label' => 'Email',
                    'attr'=>array('placeholder'=>'Email', 'class' => 'textinput')
                    ))
            ->add('username', null,  
                array(
                    'label' => 'Pseudo',
                    'attr'=>array('placeholder'=>'Pseudo', 'class' => 'textinput')
                    ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' =>  
                array(
                    'label' => 'Mot de passe',
                    'attr'=>array('placeholder'=>'Mot de passe', 'class' => 'textinput')
                    ),
                'second_options' =>  
                array(
                    'label' => 'Confirmer',
                    'attr'=>array('placeholder'=>'Confirmer mot de passe', 'class' => 'textinput')
                    ),
                'invalid_message' => 'Les mots de passes fournis ne correspondent pas',
            ))
            ->add('nom' , 'text',  
                array(
                    'label' => 'Nom',
                    'attr'=>array('placeholder'=>'Nom', 'class' => 'textinput')
                    ))
            ->add('prenoms' , 'text', 
                array(
                    'label' => 'Prenoms',
                    'attr'=>array('placeholder'=>'Prenoms', 'class' => 'textinput')
                    ))
            ->add('userType' , 'choice',
                array(
                    'label' => 'Type d\'utilisateur',
                    'choices' => array('dev' => 'Developpeur', 'admin' => 'Validateur'),
                    'attr'=>array('placeholder'=>'Prenoms', 'class' => 'textinput')
                ))
            //->add('birthdate' , 'birthday', array('label' => 'Date de naissance', 'attr' => array('class' => 'textinput')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention'  => 'registration',
        ));
    }

    public function getName()
    {
        return 'fos_user_registration';
    }
}
