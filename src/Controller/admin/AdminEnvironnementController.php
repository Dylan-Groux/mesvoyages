<?php 

namespace App\Controller\admin;

use App\Repository\EnvironnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VisiteType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Environnement;
use Doctrine\ORM\EntityManagerInterface;

class AdminEnvironnementController extends AbstractController {

    #[Route('/admin/environnements', name:'admin.environnements')]
    public function index(): Response {
        $environnements = $this->repository->findAll();
        return $this->render("admin/admin.environnements.html.twig", [
            'environnements' => $environnements
        ]);
    }

    /**
     * @var AdminEnvironnementController
     */
    private $repository;

    /**
     * Constructeur de la classe.
     * 
     * @param EnvironnementRepository $repository 
     */
    public function __construct(EnvironnementRepository $repository)
    {
        $this->repository = $repository;
    }

    
    #[Route('/admin/environnement/suppr/{id}', name:'admin.environnement.suppr')]
    public function suppr(int $id): Response {
        $environnement = $this->repository->find($id);
        $this->repository->remove($environnement);
        return $this->redirectToRoute('admin.environnements');
    }


    #[Route('/admin/environnement/ajout', name:'admin.environnement.ajout')]
    public function ajout(Request $request): Response {
        $nomEnvironnement = $request->get("nom");
        $environnement = new Environnement();
        $environnement->setNom($nomEnvironnement);
        $this->repository->add($environnement);
        return $this->redirectToRoute('admin.environnements');
    }
}