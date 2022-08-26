<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ProfileType extends AbstractType
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
                        'message' => 'Le nom de compte doit contenir au moins 3 caractères et ne pas dépasser 50 caractères',
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
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => 'form-control m-2',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\S.{1,50}\S$/',
                        'message' => 'Le mot de passe doit contenir au moins 3 caractères et ne pas dépasser 50 caractères',
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'modifier mes informations',
                'attr' => [
                    'class' => 'btn btn-primary m-2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
