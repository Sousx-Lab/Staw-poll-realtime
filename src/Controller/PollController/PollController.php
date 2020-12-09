<?php
namespace App\Controller\PollController;

use App\Repository\PollRepository;
use App\services\Entity\HandlePollResponsesVote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PollController extends AbstractController 
{
    /**
     * @param string $id
     * @Route("/vote/{id}", name="poll_vote")
     * @return Response
     */
    public function vote(PollRepository $repo, Request $request, string $id, 
    HandlePollResponsesVote $handle, 
    PublisherInterface $publisher): Response
    {   
        if(null === $poll = $repo->findOneByIdJoinedResponse($id)){
            throw $this->createNotFoundException("Aucun Sondage n'a été trouvé !");
        }
        
        if($request->request->get('poll_responses') && 
            false !== $this->isCsrfTokenValid('poll_responses', $request->request->get('token')))
            {
                $formResponseId = $request->request->get('poll_responses');
                if($handle->pollContainResponse($poll, $formResponseId)){
                    $handle->persistVote($formResponseId);
                    $jsonPoll = $this->get('serializer')->serialize($poll, 'json', ['groups' => ['poll', 'poll_response']]);
                    
                    $publisher(new Update($this->generateUrl("poll_vote", ["id" => $poll->getId()], 
                                   UrlGeneratorInterface::ABSOLUTE_URL), 
                                   $jsonPoll
                    ));
                    return new Response($jsonPoll, 200, ['Content-Type' => 'application/json']);
                }
            }
        
        return $this->render('poll/vote.html.twig', [
            'poll' => $poll
        ]);
    }

    /**
     * @Route("/voting/{id}", name="poll_voting")
     * @param Request $reqest
     * @return void
     */
    public function voting(Request $reqest)
    {
        
    }
}