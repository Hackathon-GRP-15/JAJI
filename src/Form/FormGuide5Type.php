<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormGuide5Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isDiet', ChoiceType::class, [
                'label' => 'Régime alimentaire',
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'Selectionnez une option' => '',
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'attr' => [
                    'class' => 'block mb-2 text-sm mt-2 py-4 font-medium w-full text-gray-900 dark:text-white',
                ],
            ])
            ->add(
                'diet',
                ChoiceType::class,
                [
                    'label' => 'Régime alimentaire',
                    'mapped' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'choices' => [
                        'Végétarien' => 'vegetarian',
                        'Végétalien' => 'vegan',
                        'Pesco-végétarien' => 'pesco-vegetarian',
                        'Pescarien' => 'pescetarian',
                        'Carnivore' => 'carnivore',
                        'Sans gluten' => 'gluten-free',
                        'Sans lactose' => 'lactose-free',
                        'Sans oeufs' => 'egg-free',
                        'Sans produits laitiers' => 'dairy-free',
                        'Sans produits carnés' => 'meat-free',
                        'Sans produits de la mer' => 'seafood-free',
                        'Sans produits sucrés' => 'sugar-free',
                        'Sans produits salés' => 'salt-free',
                        'Sans produits transformés' => 'processed-free',
                        'Sans produits industriels' => 'industrial-free',
                        'Sans produits animaux' => 'animal-free',
                        'Sans produits végétaux' => 'plant-free',
                        'Sans produits chimiques' => 'chemical-free',
                        'Sans produits toxiques' => 'toxic-free',
                        'Sans produits nocifs' => 'harmful-free',
                        'Sans produits dangereux' => 'dangerous-free',
                        'Sans produits polluants' => 'polluting-free'
                    ],
                    'attr' => [
                        'class' => 'bg-white py-10 ',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
