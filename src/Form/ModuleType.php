<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            //->add('position')
            ->add('type', ChoiceType::class, [
                'label' => 'Type de contenu',
                'choices' => [
                    'Texte' => 'paragraph',
                    'Titre' => 'title'
                ]
            ])
            ->add('collage', ChoiceType::class, [
                'label' => 'appliquer un effet `collage`?',
                'choices' => [
                    'oui' => 1,
                    'non' => 0
                ]
            ])
            //->add('color')
            //->add('url')
            //->add('scotch')
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
