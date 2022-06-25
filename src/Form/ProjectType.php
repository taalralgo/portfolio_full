<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Techno;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1000k',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                        'mimeTypesMessage' => "Merci de selection une image au format jpeg, jpg ou png"
                    ]),
                    new NotNull([
                        'groups' => 'Create',
                        'message' => "Merci de selectionner une image"
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => "Le nom du projet"
                ]
            ])
            ->add('startAt', DateType::class, [
                'required' => true,
                'mapped' => false,
                'widget' => 'single_text',
                'label' => 'Date de debut'
            ])
            ->add('finishAt', DateType::class, [
                'required' => true,
                'mapped' => false,
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('technos', EntityType::class, [
                'class' => Techno::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "La description du projet",
                    'rows' => '5'
                ]
            ])
            ->add('website', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Un site web ?"
                ]
            ])
            ->add('github', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Un lien github ?"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
