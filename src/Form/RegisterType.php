<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom de compte',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de compte',
                    'class' => 'form-control m-2',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\S.{1,50}\S$/',
                        'message' => 'Le nom d\'utilisateur doit contenir au moins 3 caractères et ne pas dépasser 50 caractères',
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'renseignez votre email',
                    'class' => 'form-control m-2',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Numéro de téléphone',
                    'class' => 'form-control m-2',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{0,50}$/',
                        'message' => 'Le numéro de téléphone doit pas dépasser 50 chiffres',
                    ]),
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Renseignez votre mot de passe',
                        'class' => 'form-control m-2',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmation du mot de passe',
                        'class' => 'form-control m-2',
                    ],
                ],
                'constraints' => [
                    new length([
                        'min' => 6,
                        'max' => 255,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre mot de passe ne peut pas être plus long que {{ limit }} caractères',
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary m-2',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
