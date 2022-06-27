<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'required' => false,
                'label' => "Logo de l'entreprise",
                'mapped' => false,
                "constraints" => [
                    new File([
                        'maxSize' => '500k',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                        'mimeTypesMessage' => "Merci de selection une image au format jpeg, jpg ou png"
                    ]),
                ],
            ])
            ->add('name_company', TextType::class, [
                'required' => true,
                'label' => "Nom de l'entreprise"
            ])
            ->add('name_job', TextType::class, [
                'required' => true,
                'label' => "Titre de l'emploi"
            ])
            ->add('type_contrat', TextType::class, [
                'required' => true,
                'label' => "Type de contrat"
            ])
            ->add('duree_contrat', TextType::class, [
                'required' => true,
                'label' => "La durée du contrat"
            ])
            ->add('pays', TextType::class, [
                'required' => true,
                'label' => "Pays d'obtention"
            ])
            ->add('ville', TextType::class, [
                'required' => true,
                'label' => "La ville d'obtention"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
