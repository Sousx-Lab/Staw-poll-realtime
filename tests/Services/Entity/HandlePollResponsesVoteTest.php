<?php
namespace App\Tests\Services\Entity;

use App\Repository\PollRepository;
use App\Repository\PollResponseRepository;
use App\services\Entity\HandlePollResponsesVote;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HandlePollResponsesVoteTest extends KernelTestCase
{
    use FixturesTrait;

    protected function getFixtures()
    {
        $this->loadFixtureFiles([dirname(__DIR__ , 2). '/Repository/PollRepositoryFixtures.yaml']);
    }

    protected function getHandlerVote(){
        $em = self::$container->get('doctrine.orm.entity_manager');
        return new HandlePollResponsesVote($em);
    }

    public function test_PollNotContainResponseId_ShouldReturnFalse():void
    {
        self::bootKernel();
        $this->getFixtures();
        $poll = self::$container->get(PollRepository::class)->find("a53492b0-0388-472d-9c5e-5d7043e32b5d");
        $handler = $this->getHandlerVote();
        $this->assertFalse($handler->pollContainResponse($poll, '12345'));
    }

    public function test_PollContainResponseId_ShouldReturnTrue():void
    {
        self::bootKernel();
        $this->getFixtures();
        $poll = self::$container->get(PollRepository::class)->find("a53492b0-0388-472d-9c5e-5d7043e32b5d");
        $handler = $this->getHandlerVote();
        $this->assertTrue($handler->pollContainResponse($poll, '2469fcd5-0a5c-449f-a0d5-a1e4b2ff4a9e'));
    }

    public function test_PersistVote_ShouldIncrimentPollResponseScoreAndPersistIt():void
    {
        self::bootKernel();
        $this->getFixtures();
        $repository = self::$container->get(PollResponseRepository::class);
        $pollResponse = $repository->find("2469fcd5-0a5c-449f-a0d5-a1e4b2ff4a9e");
        $this->assertEquals(0, $pollResponse->getScore());

        $handler = $this->getHandlerVote();
        $handler->persistVote($pollResponse->getId());
        $pollResponse = $repository->find("2469fcd5-0a5c-449f-a0d5-a1e4b2ff4a9e");
        $this->assertEquals(1, $pollResponse->getScore());
    }
}