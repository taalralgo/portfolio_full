<?php

namespace App\Form;

use App\Entity\Techno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TechnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '500k',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                        'mimeTypesMessage' => "Merci de selection une image au format jpeg, jpg ou png"
                    ])
                ]
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de la techno"
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description de la techno",
                    'rows' => '5'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Techno::class,
        ]);
    }
}
