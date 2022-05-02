<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $doctrine->getRepository(Article::class);

        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('accueil/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
