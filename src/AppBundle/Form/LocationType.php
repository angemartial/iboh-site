<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 09/10/2018
 * Time: 12:16
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LocationType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
    ->add('PropertyType', null, [
    "attr" => [
        'placeholder' => 'Type de propriété'
    ]
])

    ->add('submit', SubmitType::class, [
        'label' => 'Ajouter'
    ]);
}
}