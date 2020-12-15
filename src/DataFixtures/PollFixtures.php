<?php

namespace App\DataFixtures;

use App\Entity\Poll;
use App\Entity\PollResponse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PollFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    
        $poll = (new Poll())->setTitle('Poll Test');

        for($i = 0; $i < 3; $i++){
            $pollResponse = (new PollResponse())
                ->setContent('PollResponse' . $i);
                $poll->addPollResponse($pollResponse);
            }
        $manager->persist($poll);
        $manager->flush();
    }
}
