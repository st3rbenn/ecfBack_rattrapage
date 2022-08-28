<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gallery::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de collection d\'arts')
                ->setRequired(true)
                ->setFormTypeOption('attr', [
                'placeholder' => 'ex: collection d\'arts de la ville de Paris',
            ]),

            ImageField::new('image')
                ->setUploadDir('public/uploads/images'),

            TextField::new('description', 'Description de la galerie')
                ->setRequired(true)
                ->setFormTypeOption('attr', [
                    'placeholder' => 'ex: La belle collection d\'arts de la ville de Paris',
                ]),
            BooleanField::new('is_real', 'Is Real'),
            AssociationField::new('user', 'Utilisateur')->setRequired(true),
            AssociationField::new('galleryItems', 'Objets de collections'),
        ];
    }
}
