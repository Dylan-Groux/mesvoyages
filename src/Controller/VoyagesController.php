<?php 

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyagesController extends AbstractController {

    #[Route('/voyages', name:'voyages')]
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }

        /**
     * @var VisiteRepository
     */
    private $repository;

    /**
     * Constructeur de la classe.
     * 
     * @param VisiteRepository $repository 
     */
    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/voyages/tri/{champ}/{ordre}', name:'voyages.sort')]
    public function sort($champ, $ordre): Response {
        $visites = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }

}

