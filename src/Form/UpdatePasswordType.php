<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Renseignez votre mot de passe',
                        'class' => 'form-control m-2',
                        'id' => 'passsword_id',
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
                        'allowEmptyString' => false,
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
