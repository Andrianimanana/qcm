<?php

namespace App\Controller;

use App\Entity\ChoisirReponse;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\ChoisirReponseType;
use App\Init\DateInit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QcmController extends AbstractController
{ 
    
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

    /**
     * @Route("/{index_question}", name="qcm_home", requirements={"index_question":"\d+"})
     */
    public function index($index_question= 0, Request $request): Response
    {         
    	//
    	if(!$this->getUser())
    		return $this->redirectToRoute('app_login');
    	
    	//
    	$questions 	= new ArrayCollection($this->getDoctrine()->getRepository(Question::class)->findQuestionHaveReponse());
    	
    	//
    	if(!$questions->containsKey($index_question))
    		throw $this->createNotFoundException("Question $index_question n'existe pas.");

    	//
    	$question 		= $questions->get($index_question); 
    	$reponses 		= $question->getReponses();
 
        //        
        $choix_reponse 	= new ChoisirReponse();
	    $form 			= $this->createForm(
	    	ChoisirReponseType::class, 
	    	$choix_reponse, [
	    	"reponses" 	=> $reponses, 
	    	"question" 	=> [$question]
	    ]);

	    $form->handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()){         	
	    	$choix_reponse->setDate(DateInit::dateNow()); 
	    	$choix_reponse->setUser($this->getUser());  
	    	$this->em->persist($choix_reponse);
	    	$this->em->flush();
			  
			if($question == $questions->last())
				return $this->render('qcm/final.html.twig');
			 
			$next_question = $questions->key();
			
			return $this->redirectToRoute('qcm_home',[
				"index_question" => $next_question
			]);    	
	    }
        
        //
        return $this->render('qcm/index.html.twig', [
            'reponses' 	=> $reponses,
            'question' 	=> $question,
            'form' 		=> $form->createView()
        ]);
    }
}
