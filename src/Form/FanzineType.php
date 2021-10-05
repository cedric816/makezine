<?php

namespace App\Form;

use App\Entity\Fanzine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FanzineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                "label" => false,
                "attr" => [
                    "placeholder" => "titre"
                ]
            ])
            ->add('abstract', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "résumé"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fanzine::class,
        ]);
    }
}
