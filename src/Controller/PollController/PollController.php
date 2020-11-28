<?php
namespace App\Controller\PollController;

use App\Repository\PollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PollController extends AbstractController 
{
    /**
     * @param string $id
     * @Route("/vote/{id}", name="poll_vote")
     * @return Response
     */
    public function vote(PollRepository $repo, string $id): Response
    {   
        if(null === $poll = $repo->findOneByIdJoinedResponse($id)){
            throw $this->createNotFoundException("Aucun Sondage n'a été trouvé !");
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