<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormGuide4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('concentration', ChoiceType::class, [
                'label' => 'Concentration',
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'Selectionnez une option' => '',
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'attr' => [
                    'class' => 'block mb-2 text-sm py-4 font-medium w-full text-gray-900 dark:text-white',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
