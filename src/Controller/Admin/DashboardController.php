<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Article;
use App\Entity\Comment;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony CMS')
            //->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>'
            ->setFaviconPath('favicon.svg')
            ->setTranslationDomain('my-custom-domain')
            ->setTextDirection('ltr')
            ->renderContentMaximized()
            ->disableUrlSignatures()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToRoute('Aller sur le site', 'fa fa-undo', 'app_accueil'),

            MenuItem::subMenu('Articles', 'fa fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('Liste des articles', 'fa fa-newspaper', Article::class),
                MenuItem::linkToCrud('Ajouter un article', 'fa fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
            ]),

            MenuItem::subMenu('Livres', 'fa fa-book')->setSubItems([
                MenuItem::linkToCrud('Liste des livres', 'fa fa-book', Livre::class),
                MenuItem::linkToCrud('Ajouter un livre', 'fa fa-plus', Livre::class)->setAction(Crud::PAGE_NEW),
            ]),

            MenuItem::subMenu('Users', 'fa fa-user')->setSubItems([
                MenuItem::linkToCrud('Liste des users', 'fa fa-user', User::class),
                MenuItem::linkToCrud('Ajouter un user', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            ]),

            MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class),
        ];
    }
}
