<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 09/10/2018
 * Time: 12:10
 */

namespace AppBundle\Form;


use AppBundle\Entity\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//
            ->add('LocationType', null, [
                "attr" => [
                    'placeholder' => 'Localité'
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Extra\PropertySearch'
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_propertysearch';
    }
}