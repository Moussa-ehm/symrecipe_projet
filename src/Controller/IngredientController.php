<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    /**
     * Fonction permettant d'afficher tous les ingredients et les affichers
     * Injection de dépendance avec le repository
     * Appel de la fonction findAll
     * Injection de paginatorInterface pour gérer la pagination de la page et en afficher 10 max à chaque fois
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'app_ingredient', methods: ['GET'])]
    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $ingredients = $paginator->paginate(
            $repository->findAll(), /* Reqête */
            $request->query->getInt('page', 1), /*Nombre de page*/
            10 /*page Max*/
        );
        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }
}
