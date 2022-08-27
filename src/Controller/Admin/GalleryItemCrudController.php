<?php

namespace App\Controller\Admin;

use App\Entity\GalleryItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\FormBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class GalleryItemCrudController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class GalleryItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GalleryItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de l\'objet')->setFormTypeOption('constraints', [
                new Regex([
                    'pattern' => '/^\S.{1,100}\S$/',
                    'message' => 'Le nom de la collection d\'arts ne doit pas dépasser 100 caractères',
                ]),
            ]),
            ImageField::new('image')->setUploadDir('public/uploads/images'),
            TextField::new('description', 'Description de l\'objet')->setFormTypeOption('constraints', [
                new Regex([
                    'pattern' => '/^\S.{1,100}\S$/',
                    'message' => 'La description de l\'objet ne doit pas dépasser 100 caractères',
                ]),
            ]),
            AssociationField::new('gallery', 'Galerie'),
        ];
    }
}
