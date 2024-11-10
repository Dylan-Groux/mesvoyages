<?php 

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

class VisiteTest extends TestCase {

    public function testGetDatecreationString(){
        $visite = new Visite();
        $visite->setDateCreationString(new \DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDateCreationString());
    }
}