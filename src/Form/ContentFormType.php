<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\Media;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('selectTag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'label' => 'Choisisez un ou pliseur Tags affiliés au contenu',
                'attr' => [
                    'class' => 'form-control',
                ],
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
            ])
           ->add('name', TextType::class, [
               'label' => 'Titre de l\'article: ',
               'help' => '',
               'attr' => [
                   'class' => 'form-control w-full',
               ],
               'mapped' => true,
               'required' => true,
           ])
             ->add('file_header', FileType::class,[
                //'class' => Media::class,
                'label' => 'Image :',
                'help' => '',
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/*',
                ],
                'multiple' => false,
                'mapped' => false,
                'required' => true,
            ])
            ->add('file_video', FileType::class,[
                 'label' => 'Vidéo :',
                 'help' => '',
                 'attr' => [
                     'class' => 'form-control',
                     'accept' => 'video/*',
                 ],
                 'multiple' => false,
                 'mapped' => false,
                 'required' => true,
             ])
            ->add('description', CKEditorType::class, array(
                'config' => [
                    'toolbar' => 'full',
                    'height' => '500px',
                    'language' => 'en',
                ],
                'label' => 'Texte de l\'article :',
            ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
