<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormGuide3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sport', ChoiceType::class, [
                'label' => 'Sport',
                'multiple' => true,
                'expanded' => true,
                'mapped' => false,
                'choices' => [
                    'Football' => 'football',
                    'Basketball' => 'basketball',
                    'Tennis' => 'tennis',
                    'Rugby' => 'rugby',
                    'Handball' => 'handball',
                    'Volleyball' => 'volleyball',
                    'Athlétisme' => 'athletics',
                    'Golf' => 'golf',
                    'Cyclisme' => 'cycling',
                    'Natation' => 'swimming',
                    'Aviron' => 'rowing',
                    'Boxe' => 'boxing',
                    'Judo' => 'judo',
                    'Taekwondo' => 'taekwondo',
                    'Escalade' => 'climbing',
                    'Equitation' => 'horse-riding',
                    'Ski' => 'ski',
                    'Snowboard' => 'snowboard',
                    'Autre' => 'other',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
