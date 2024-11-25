<?php 

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\VisiteRepository;
use App\Entity\Visite;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;

class VoyagesControllerTest extends WebTestCase {

    public function testAccesPage() {
        $client = static::createClient();
        $client->request('GET', "/voyages");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testContenuPage()
    {
        // Simuler la requête GET
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');

        // Vérifier que la page contient un h1
        $this->assertGreaterThan(0, $crawler->filter('th')->count(), 'A <tr> tag was not found!');
        $this->assertSelectorTextContains('th', 'Ville');
    }

    public function testLinkVille()
    {
        // Simuler la requête GET
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        
        // Simule le clic sur le lien "Rạch Giá"
        $crawler = $client->clickLink('Rạch Giá');
    
        // Obtenez la réponse
        $response = $client->getResponse();
        dd($client->getRequest());
    
        // Vérifiez que la réponse a un statut HTTP 200
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    
        // Vérifiez que l'URI de la requête est correcte
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/voyages/voyage/2', $uri);
    }

    public function testFiltreVille () 
    {
        // Simuler la requête GET
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');

        $crawler = $client->submitForm('FILTRER', ['recherche' => 'Rạch Giá']);

        $this->assertCount(1, $crawler->filter('tbody tr'));
        $this->assertSelectorTextContains('tbody tr', 'Rạch Giá');
    }
}