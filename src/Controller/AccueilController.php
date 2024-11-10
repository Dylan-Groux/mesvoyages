<?php 

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController {

    /**
     * @var VisiteRepository
     */
    private $repository;

    /**
     * Constructeur avec injection du repository.
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
    }


    #[Route('/', name:'accueil')]
    public function index(): Response {
        $latestVisites = $this->repository->findLatestVisite();

        return $this->render("pages/accueil.html.twig", [
            'latestVisites' => $latestVisites,
        ]);
    }

}