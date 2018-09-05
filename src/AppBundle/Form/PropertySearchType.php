<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 10/08/2018
 * Time: 17:17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('location', EntityType::class, [
            'label' => 'Commune',
            'class' => Location::class,
            'choice_label' => 'title',
            'attr' => [
                'class' => 'selectpicker',
                'title' => 'Commune',
                'data-hide-disabled' => 'true',
                'data-live-search' => 'true'
            ]
        ])
        ->add('subLocation', null, [
            "attr" => [
                'placeholder' => 'Quartier'
            ]
        ])
        ->add('minArea', null, [
            "attr" => [
                'placeholder' => 'Superficie min'
            ]
        ])
        ->add('maxArea', null, [
            "attr" => [
                'placeholder' => 'Superficie max'
            ]
        ])
        ->add('bedRooms', null, [
            "attr" => [
                'placeholder' => 'Chambres'
            ]
        ])
        ->add('bathRooms', null, [
            "attr" => [
                'placeholder' => 'Salles de bain'
            ]
        ])
        ->add('priceMin', null, [
            'label' => 'Prix'
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Trouver'
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