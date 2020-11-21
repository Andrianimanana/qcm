<?php

namespace App\Controller;

use App\Entity\ChoisirReponse;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\ChoisirReponseType;
use App\Init\DateInit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QcmController extends AbstractController
{
    /**
     * @Route("/{index_question}", name="qcm_home", requirements={"index_question":"\d+"})
     */
    public function index(Question $question, $index_question = 1, Request $request): Response
    {         
    	//
    	if(!$this->getUser())
    		return $this->redirectToRoute('app_login');

        //
        if(!$question->getReponses()->count())
        	dd("fini");

        $em     		= $this->getDoctrine()->getManager();
    	$reponses 		= $question->getReponses();    		 
        $choix_reponse 	= new ChoisirReponse();

        $form = $this->createForm(ChoisirReponseType::class, $choix_reponse);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        	$reponse_choisi = $this->getDoctrine()->getRepository(Reponse::class)->find($request->request->get('reponse'));        	
        	$choix_reponse->setDate(DateInit::dateNow());
        	$choix_reponse->setReponse($reponse_choisi);
        	$choix_reponse->setUser($this->getUser());
        	$em->persist($choix_reponse);
        	$em->flush(); 
    		return $this->redirectToRoute('qcm_home',["index_question" => ++$index_question]);        	
        }
    	
        
        return $this->render('qcm/index.html.twig', [
            'reponses' 	=> $reponses,
            'question' 	=> $question,
            'form' 		=> $form->createView()
        ]);
    }
}
