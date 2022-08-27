<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use App\Entity\GalleryItem;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {

        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EcfBack Rattrapage');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Galeries'),
            MenuItem::linkToCrud('Les galeries', 'fa fa-tags', Gallery::class),
            MenuItem::linkToCrud('Les objets de collections', 'fa fa-file-text', GalleryItem::class),

            MenuItem::section('Users'),
            /*MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),*/
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
        ];
    }
}
