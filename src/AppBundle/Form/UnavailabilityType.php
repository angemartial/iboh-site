<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnavailabilityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToDateTransformer();
        $builder-> add (
            $builder->create('begins', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Début'
                ]
            ])
                    ->addModelTransformer($transformer)
        )
            -> add (
                $builder->create('ends', TextType::class, [
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Fin',
                        'value' => ''
                    ]
                ])
                        ->addModelTransformer($transformer)
            )
            -> add ( 'reason', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Raison'
                ],
            ] )
            -> add ( 'type', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Type'
                ]
            ] );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Unavailability'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'AppBundle_unavailability';
    }
}
