<?php

namespace App\Form;

use App\Entity\GalleryItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class GalleryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'art',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex:  La Joconde',
                    'class' => 'form-control m-2',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'description de l\'art',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex:  La Joconde est une peinture à l\'huile sur bois de 77 cm de hauteur par 53 cm de largeur réalisée entre 1503 et 1506 par Léonard de Vinci.',
                    'class' => 'form-control m-2',
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'form-control m-2',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'ajouter un art',
                'attr' => [
                    'class' => 'btn btn-primary m-2',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GalleryItem::class,
        ]);
    }
}
