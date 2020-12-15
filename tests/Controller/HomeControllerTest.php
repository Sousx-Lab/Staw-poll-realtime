<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase{
    
    protected KernelBrowser $client;

    protected function setUp(): KernelBrowser
    {
        return $this->client = static::createClient();
    }

    public function test_HomePageRoute_ShouldReturnSuccessfulResponse(): void
    {
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function test_CountDefaultFieldsForm_ShouldEqualToFour(): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertSelectorExists('form');
        $fields = $crawler
                ->filter('input[type=text]')
                ->count();
        $this->assertEquals(4, $fields);
    }

    public function test_CountTokenFieldFrom_ShouldEqualToOne():void
    {
        $crawler = $this->client->request('GET', '/');
        $fields = $crawler
                 ->filter('input[id=poll__token]')
                 ->count();
        $this->assertEquals(1, $fields);
    }

    public function test_FormWithoutPollTitle_ShouldReturnAssertNotBlankError(): void
    {
        $crawler = $this->client->request('GET', '/');
        $form = $crawler->selectButton('Créer le sondage')->form(null, 'POST');
        $this->client->submit($form);
        $this->assertRegExp('/Ce champ ne peut pas étres vide/', $this->client->getResponse()->getContent());
    }

    public function test_FormPollResponseLength_ShouldReturnAssertLengthError(): void
    {
        $crawler = $this->client->request('GET', '/');
        $form = $crawler->selectButton('Créer le sondage')
                    ->form([
                    'poll[title]' => 'Poll test ?',
                    'poll[pollResponse][0][content]' => 't',
                    'poll[pollResponse][1][content]' => 'e',
                    ]);
        $this->client->submit($form);
        $this->assertRegExp('/Veuillez reformulez vos réponses , 2 caractères minimum/', $this->client->getResponse()->getContent());
        
    }

    public function test_FormWithLessThanTwoPollResponses_ShouldReturnError():void
    {
        $crawler = $this->client->request('GET', '/');
        $form = $crawler->selectButton('Créer le sondage')
                    ->form([
                        'poll[title]' => 'Poll test ?'
                    ]);
        $this->client->submit($form);
        $this->assertRegExp('/Au moins 2 réponses pour créer le sondage/', $this->client->getResponse()->getContent());
    }

    public function test_SubmitValidForm_ShouldRedirectToVotePage():void
    {
        $crawler = $this->client->request('GET', '/');
        $form = $crawler->selectButton('Créer le sondage')
                    ->form([
                        'poll[title]' => 'Poll test ?',
                        'poll[pollResponse][0][content]' => 'Test 1',
                        'poll[pollResponse][1][content]' => 'Test 2',
                    ]);
        $this->client->submit($form);
        $this->assertSame(303, $this->client->getResponse()->getStatusCode());
    }
}