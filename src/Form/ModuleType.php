<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', null, [
                'label' => false
            ])
            //->add('position')
            ->add('type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    '' => '',
                    'Texte' => 'paragraph',
                    'Titre' => 'title',
                    'Image' => 'image'
                ]
            ])
            ->add('collage', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'oui' => 1,
                    'non' => 0
                ]
            ])
            //->add('color')
            ->add('url', FileType::class, [
                'label' => false,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'image au format jpg ou jpeg svp - taille max 5000k',
                    ])
                ],
            ])
            ->add('legend', null, [
                'label'=> false
            ])
            ->add('scotch', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'oui' => 1,
                    'non' => 0
                ]
            ])
            //->add('page')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
