<?php

namespace App\Controller;

use DateTime;
use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $livre = new Livre();

        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $livre->setDate(new DateTime());

            $livre->setUser($user);

            $em = $doctrine->getManager();
            $em->persist($livre);
            $em->flush();
            $this->addFlash('success', 'Votre livre a été ajouté');

            return $this->redirectToRoute('show_livre');
        }

        return $this->render('livre/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/livres', name: 'show_livre')]
    public function show(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        $livre = $user->getLivres();

        $repository = $doctrine->getRepository(Livre::class);

        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('livre/show.html.twig', [
            'livres' => $livre,
            'pagination' => $pagination
        ]);
    }
}
