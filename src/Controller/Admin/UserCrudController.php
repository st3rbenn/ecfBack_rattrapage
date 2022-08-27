<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username', 'Nom d\'utilisateur')->setFormTypeOption('constraints', [
                new Regex([
                    'pattern' => '/^\S.{1,100}\S$/',
                    'message' => 'Le nom d\'utilisateur ne doit pas dépasser 100 caractères',
                ]),
            ]),
            EmailField::new('email', 'Email')->setFormType(EmailType::class)->setFormTypeOption('constraints', [
                new Regex([
                    'pattern' => '/^\S.{1,100}\S$/',
                    'message' => 'L\'email ne doit pas dépasser 100 caractères',
                ]),
            ]),
            TextField::new('password', 'Mot de passe')->setFormType(RepeatedType::class)->setFormTypeOption('type', PasswordType::class)->setFormTypeOption('first_options', [
                'label' => 'Mot de passe',
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])->setFormTypeOption('second_options', [
                'label' => 'Confirmer le mot de passe',
            ]),
        ];
    }
}
