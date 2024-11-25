<?php 

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\VisiteRepository;
use App\Entity\Visite;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VisiteRepositoryTest extends KernelTestCase {
    public function recupRepository() : VisiteRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }

    public function testNbVisites() {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(2, $nbVisites);
    }

    public function  newVisite() : Visite {
        $visite = (new Visite ())
                ->setVille("New York")
                ->setPays("USA")
                ->setDatecreation(new \DateTime("now"));
        return $visite;
    }

    public function testAddVisite() {
        $repository = $this->recupRepository();
        $visite= $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite, true);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "erreur lors de l'ajout");
    }

    public function testRemoveVisite() {
        $repository = $this->recupRepository();
        $visite= $this->newVisite();
        $repository->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites - 1, $repository->count([]), "erreur lors de la suppression");
    }

    public function testFindByEqualValue() {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue("ville", "New York");
        $nbVisites = count($visites);
        $this->assertEquals(1, $nbVisites);
    }
}