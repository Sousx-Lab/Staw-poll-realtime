<?php
namespace App\services\Entity;

use App\Entity\Poll;
use App\Entity\PollResponse;
use Doctrine\ORM\EntityManagerInterface;

class HandlePollResponsesVote {
    
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function pollContainResponse(Poll $poll, string $voteId): bool
    {
        if(true !== $poll->getPollResponse()->exists(function($key, $value) use($voteId){
            return $value->getId() === $voteId;}))
        {
            return false;
        }
        return true;
    }

    public function persistVote($voteId) :void
    {
        $PollResponse = $this->em->getRepository(PollResponse::class)->find($voteId);
        $PollResponse->incrementScore();
        $this->em->flush();
    }


}