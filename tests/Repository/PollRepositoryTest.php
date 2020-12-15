<?php
namespace App\Tests\Repository;

use App\Entity\Poll;
use App\Repository\PollRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PollRepositoryRest extends KernelTestCase {

    use FixturesTrait;

    public function test_Count():void
    {
        self::bootKernel();
        $this->loadFixtureFiles([__DIR__ . '/PollRepositoryFixtures.yaml']);
        $poll = self::$container->get(PollRepository::class)->count([]);
        $this->assertEquals(1, $poll);
    }

    public function test_FindOneByIdJoinedResponse_ShouldReturnPoll():void
    {
        self::bootKernel();
        $this->loadFixtureFiles([__DIR__ . '/PollRepositoryFixtures.yaml']);
        $poll = self::$container->get(PollRepository::class)->findOneByIdJoinedResponse('a53492b0-0388-472d-9c5e-5d7043e32b5d');
        $this->assertInstanceOf(Poll::class, $poll);
        $this->assertCount(1, [$poll]);
    }

    public function testFindOneByIdJoinedResponse_ShouldReturnNull():void
    {
        self::bootKernel();
        $this->loadFixtureFiles([__DIR__ . '/PollRepositoryFixtures.yaml']);
        $poll = self::$container->get(PollRepository::class)->findOneByIdJoinedResponse('z53492b0-0388-472d-9c5e-5d7043e32b5b');
        $this->assertNull($poll);
    }
    
}