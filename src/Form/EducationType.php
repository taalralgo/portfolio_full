<?php

namespace App\Form;

use App\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('school', TextType::class, [
                'required' => true,
                'label' => "Etablissement",
                'attr' => [
                    'placeholder' => "Le nom de l'etablissement"
                ]
            ])
            ->add('diplome', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Le diplome obtenu"
                ]
            ])
            ->add('startAt', DateType::class, [
                'required' => true,
                'label' => "Date de debut",
                'widget' => 'single_text'
            ])
            ->add('finishAt', DateType::class, [
                'required' => true,
                'label' => "Date de fin",
                'widget' => 'single_text'
            ])
            ->add('pays', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Pays d'obtention du diplome"
                ]
            ])
            ->add('ville', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Ville d'obtention du diplome"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Education::class,
        ]);
    }
}
