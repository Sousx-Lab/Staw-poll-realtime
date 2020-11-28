<?php

namespace App\Controller;

use App\Entity\Poll;
use App\Form\PollType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function create(Request $request): Response
    {
        $poll = new Poll();
        
        $form = $this->createForm(PollType::class, $poll);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            dd($poll);
            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->flush();
            return $this->redirectToRoute("poll_vote", ["id" => $poll->getId()]);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
