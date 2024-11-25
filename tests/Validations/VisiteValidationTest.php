<?php 

namespace App\Tests\Validations;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Visite;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VisiteValidationTest extends KernelTestCase {
    public function getVisite() : Visite {
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }


    public function testValidNoteVisite() {
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0);

        $visite = $this->getVisite()->setNote(0);
        $this->assertErrors($visite, 0);

        $visite = $this->getVisite()->setNote(20);
        $this->assertErrors($visite, 0);
    }

        
    public function testNonValidNoteVisite() {

        $visite = $this->getVisite()->setNote(-1); #attente d'une erreur ici
        $this->assertErrors($visite, 1);

        $visite = $this->getVisite()->setNote(21); #attente d'une erreur ici
        $this->assertErrors($visite, 1);

        $visite = $this->getVisite()->setNote(-100);
        $this->assertErrors($visite, 1);

        $visite = $this->getVisite()->setNote(100);
        $this->assertErrors($visite, 1);
    }

    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message="") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $errors, $message);
    }


    public function testNonValidTempmaxVisite() {
    // Cas 3 : Deux températures incorrectes éloignées (tempmax < tempmin)
    $visite = $this->getVisite()
    ->setTempmin(20)
    ->setTempmax(10);
    $this->assertErrors($visite, 1, "min=20, max=10 devrait échouer");

    // Cas 4 : Deux températures identiques (tempmin == tempmax)
    $visite = $this->getVisite()
    ->setTempmin(25)
    ->setTempmax(25);
    $this->assertErrors($visite, 1, "min=25, max=25 devrait réussir si accepté mais pas gérer dans notre cas");

    // Cas 5 : Vérification avec une différence logique mais proche (ex : min = 18, max = 17, donc max < min)
    $visite = $this->getVisite()
    ->setTempmin(18)
    ->setTempmax(17);
    $this->assertErrors($visite, 1, "min=18, max=17 devrait échouer");
    }
    
    public function testValidTempmaxVisite() {
    // Cas 1 : Deux températures correctes et éloignées
    $visite = $this->getVisite()
        ->setTempmin(10)
        ->setTempmax(30);
    $this->assertErrors($visite, 0, "min=10, max=30 devrait réussir");

    // Cas 2 : Deux températures correctes qui se suivent
    $visite = $this->getVisite()
        ->setTempmin(15)
        ->setTempmax(16);
    $this->assertErrors($visite, 0, "min=15, max=16 devrait réussir");
    }

    public function testDateCreationValidations() {
        $visite = $this->getVisite();

    // Cas valide : Une date antérieure
    $visite->setDatecreation(new \DateTime('-1 day'));
    $this->assertErrors($visite, 0, "Une date antérieure à aujourd'hui devrait réussir.");

    // Cas valide : Aujourd'hui
    $visite->setDatecreation(new \DateTime('today'));
    $this->assertErrors($visite, 0, "La date d'aujourd'hui devrait réussir.");

    // Cas invalide : Demain
    $this->expectException(\InvalidArgumentException::class);
    $visite->setDatecreation(new \DateTime('+1 day'));

    // Cas invalide : L'année prochaine
    $this->expectException(\InvalidArgumentException::class);
    $visite->setDatecreation(new \DateTime('+1 year'));
    }



}