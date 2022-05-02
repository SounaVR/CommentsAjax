<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(): Response
    {
        $companies = [
            'Apple' => 'trop d\'argent',
            'Samsung' => 'moins riche que Apple',
            'Microsoft' => 'Presque comme Apple'
        ];
        return $this->render('list/index.html.twig', [
            'companies' => $companies
        ]);
    }
}
