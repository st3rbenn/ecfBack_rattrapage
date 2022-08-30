<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\GalleryItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextType::class, [
                'label' => 'Ajouter un commentaire',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Commentaire',
                    'class' => 'form-control m-2',
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le commentaire doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le commentaire ne doit pas dépasser {{ limit }} caractères',
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary m-2',
                ],
            ])
            ->add('galleryItemId', EntityType::class, [
                'class' => GalleryItem::class,
                'choice_label' => 'name',
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control m-2',
                    'style' => 'display: none;',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
