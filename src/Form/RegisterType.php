<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'help' => 'form.help.email',
                'attr' => [
                    'class' => 'appearance-none rounded-md border border-gray-300 px-4 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none gap: 3 focus:ring-indigo-500 sm:text-sm',
                ],
                'mapped' => true,
                'required' => true,
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'help' => 'form.help.username',
                'attr' => [
                    'class' => 'appearance-none rounded-md rounded-t-md border  border-gray-300 px-3 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',

                ],

                'mapped' => true,
                'required' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'appearance-none rounded-md border border-gray-300 px-3 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'class' => 'appearance-none rounded-md rounded-md border border-gray-300 px-3 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    ],
                ],
                'help' => 'form.help.password',
                'form_attr' => true,
                'mapped' => true,
                'required' => true,
                'constraints' => [
                    new Callback([
                        'callback' => function ($password, ExecutionContextInterface $context) {
                            $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
                            if (!preg_match($regex, $password)) {
                                $context->buildViolation('Votre mot de passe doit comporter au moins 8 caractères et contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial')
                                    ->addViolation();
                            }
                        },
                    ]),
                ],


            ])->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500',
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter notre politique de confidentialité.',
                    ]),
                ],
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
