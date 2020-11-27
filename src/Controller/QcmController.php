<?php

namespace App\Controller;

use App\Entity\ChoisirReponse;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\ChoisirReponseType;
use App\Init\DateInit;
use App\Repository\ChoisirReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class QcmController extends AbstractController
{ 
    
	private $em;
	private $session;

	public function __construct(EntityManagerInterface $em, SessionInterface $session)
	{
		$this->em 		= $em;
		$this->session 	= $session;
	}

    /**
     * @Route("/", name="qcm_home")
     */
    public function index(Request $request): Response
    {         
    	//
    	if(!$this->getUser())
    		return $this->redirectToRoute('app_login');
    	
    	// recupère toutes les questions 
    	$questions 	= new ArrayCollection($this->getDoctrine()->getRepository(Question::class)->findQuestionHaveReponse());
    	
    	$current_question 	= $this->session->get("current_question") ?? 0;
    	
    	// end question
    	if($questions->count() <= $current_question){
			$results = new ArrayCollection($this->getDoctrine()->getRepository(ChoisirReponse::class)->findResults($this->getUser()));
    		
    		$this->session->clear("current_question");// reinitialise question
    		
    		return $this->render('qcm/final.html.twig', [
    			"results_true" 		=> $results->count(),
    			"total_questions"  	=> $questions->count()
    		]);
    	}
    	// recupère la question courrante
    	$question 		= $questions->get($current_question); 
    	$reponses 		= $question->getReponses();
       
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
	    	// passé au question suivante
	    	$this->session->set("current_question", $current_question + 1);
			
			return $this->redirectToRoute('qcm_home');    	
	    }
        
        //
        return $this->render('qcm/index.html.twig', [
            'reponses' 	=> $reponses,
            'question' 	=> $question,
            'form' 		=> $form->createView()
        ]);
    }

    /**
     * @Route("/result-detail", name="qcm_resultdetail")
     */
    public function getDetailResult(ChoisirReponseRepository $cr)
    {
            dd($cr->getDetailResult($this->getUser()));
    }
}
