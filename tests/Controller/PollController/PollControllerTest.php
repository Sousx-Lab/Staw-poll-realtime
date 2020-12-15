<?php
namespace App\Tests\Controller\PollController;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PollControllerTest extends WebTestCase{
    

    protected KernelBrowser $client;
    use FixturesTrait;
    
    protected function setUp(): KernelBrowser
    {
        return $this->client = static::createClient();
    }

    public function test_WithBadPollIdRequest_ShouldReturnNotFoundException():void
    {
        $this->client->request('GET', "/vote/12345");
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertRegExp("/Aucun Sondage n'a été trouvé !/", $this->client->getResponse()->getContent());
    }

    public function test_WithGoodPollIdRequest_ShouldReturnSuccessfulResponse()
    {
        $this->loadFixtureFiles([dirname(__DIR__ , 2). '/Repository/PollRepositoryFixtures.yaml']);
        $this->client->request('GET', '/vote/a53492b0-0388-472d-9c5e-5d7043e32b5d');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertRegExp("/Poll_title_test_1/", $this->client->getResponse()->getContent());
    }

    public function test_WhitBadKeyPostRequest_ShouldReturnBadRequestException():void
    {
        $this->loadFixtureFiles([dirname(__DIR__ , 2). '/Repository/PollRepositoryFixtures.yaml']);
        $this->client->request('POST', '/vote/a53492b0-0388-472d-9c5e-5d7043e32b5d', [
            'poll_resp' => 'Response 1',
            'token'     => ''
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function test_WhitBadCsrfTokenRequest_ShouldReturnBadRequestException():void
    {
        $this->client->getKernel()->boot();
        $this->client->getContainer()->get('security.csrf.token_manager')->getToken('poll_responses');
        $this->loadFixtureFiles([dirname(__DIR__ , 2). '/Repository/PollRepositoryFixtures.yaml']);
        $this->client->request('POST', '/vote/a53492b0-0388-472d-9c5e-5d7043e32b5d', [
            'poll_responses' => '2469fcd5-0a5c-449f-a0d5-a1e4b2ff4a9e',
            'token'     => '123456789',
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function test_WhitGoodCsrfTokenRequest_ShouldReturnSuccessfulJsonResponse():void
    {
        $this->client->getKernel()->boot();
        $csrfToken = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('poll_responses');
        $this->loadFixtureFiles([dirname(__DIR__ , 2). '/Repository/PollRepositoryFixtures.yaml']);
        $this->client->request('POST', '/vote/a53492b0-0388-472d-9c5e-5d7043e32b5d', [
            'poll_responses' => "2469fcd5-0a5c-449f-a0d5-a1e4b2ff4a9e",
            'token'          => $csrfToken->getValue(),
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }
    
}