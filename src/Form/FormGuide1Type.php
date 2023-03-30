<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormGuide1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('job', ChoiceType::class, [
                'label' => 'Profession',
                'mapped' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Etudiant' => 'student',
                    'Salarié' => 'employee',
                    'Indépendant' => 'freelance',
                    'Retraité' => 'retired',
                    'Développeur web' => 'developer',
                ],
                'attr' => [
                    'class' => 'form-check-input',

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
