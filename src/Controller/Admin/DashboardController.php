<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Reponse;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Qcm');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Administration', 'fa fa-home'),
            MenuItem::section('Mise à jour'),
                MenuItem::linkToCrud('Question', 'far fa-question-circle', Question::class),
                MenuItem::linkToCrud('Reponse', 'fab fa-replyd', Reponse::class),
                MenuItem::linkToCrud('Categorie', 'fa fa-list-alt', Category::class),
        ];
    }
}
