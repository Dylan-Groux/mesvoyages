<?php 

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Visite;
use App\Entity\Environnement;
use PHPUnit\Framework\TestCase;

class VisiteTest extends TestCase {

    public function testGetDatecreationString(){
        $visite = new Visite();
        $visite->setDatecreationFromString("2024-04-24");
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }

    public function testSetDatecreationFromStringInvalidDate()
    {
        // Nous attendons une exception InvalidArgumentException
        $this->expectException(\InvalidArgumentException::class);
        
        // Crée une instance de la classe Visite
        $visite = new Visite();

        // Essaie de définir une date invalide
        $visite->setDatecreationFromString('invalid-date');  // Devrait lever une exception
    }

    public function testAddDuplicateEnvironnement() {
        $visite = new Visite(); // Instanciation de la visite
        $environnement = new Environnement(); // Crée un environnement (exemple)
        $environnement->setNom('Montagne'); // Attribuez un nom ou autre propriété pour identifier l'environnement
    
        // Ajout de l'environnement une première fois
        $visite->addEnvironnement($environnement);
    
        // Tentative d'ajout du même environnement une deuxième fois
        $visite->addEnvironnement($environnement);
    
        // Vérification : la collection d'environnements ne doit contenir qu'une seule instance
        $this->assertCount(
            1,
            $visite->getEnvironnements(),
            "L'environnement ne doit pas être ajouté deux fois."
        );
    }

}
