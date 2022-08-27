<?php

namespace App\Form;

use App\Entity\Gallery;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de collection d\'arts',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex: collection d\'arts de la ville de Paris',
                    'class' => 'form-control m-2',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\S.{1,100}\S$/',
                        'message' => 'Le nom de la collection d\'arts ne doit pas dépasser 100 caractères',
                    ]),
                ]
            ])
            ->add('is_real', CheckboxType::class, [
                'label' => 'objet réel',
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'data_class' => null,
                'data' => null,
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
            ->add('description', TextType::class, [
                'label' => 'description de la collection d\'arts',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex: La belle collection d\'arts de la ville de Paris',
                    'class' => 'form-control m-2',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary m-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}
