<?php

namespace App\Controller;

use App\Entity\Poll;
use App\Form\PollType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        $poll = new Poll();
        
        $form = $this->createForm(PollType::class, $poll);

        /**Check minimum required pollResponse (2) */
        $form->handleRequest($request);
        if($form->isSubmitted() && $poll->getPollResponse()->count() < 2 )
        {
            $form->addError(new FormError('Au moins 2 réponses pour créer le sondage'));
            
        }
        /** Validate pollResponse length */
        $errors = $validator->validate($poll->getPollResponse());
        if($errors->count() > 0){
            foreach($errors as $error){
                $form->addError(new FormError($error->getMessage()));
            }
            
        }
        
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->flush();
            return $this->redirectToRoute("poll_vote", ["id" => $poll->getId()], 303);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
