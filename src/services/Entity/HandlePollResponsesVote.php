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
        return $poll->getPollResponse()->exists(function($key, $value) use($voteId){
            return $value->getId() === $voteId;}) ? true : false;
    }

    public function persistVote(string $voteId) :void
    {
        $PollResponse = $this->em->getRepository(PollResponse::class)->find($voteId);
        $PollResponse->incrementScore();
        $this->em->flush();
    }


}