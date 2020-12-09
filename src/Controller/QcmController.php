<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ChoisirReponse;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\ChoisirReponseType;
use App\Init\QcmCollection;
use App\Init\DateInit;
use App\Repository\ChoisirReponseRepository; 
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
     * @Route("/", name="qcm_index")
     */
    public function index(){
       
       $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
       

       return $this->render("qcm/index.html.twig", [
            "categories" => $categories
       ]); 
    }
    /**
     * @Route("/qcm/cat-{libele}", name="qcm_question") 
     */
    public function qcm_question(Category $category, Request $request): Response
    {         
    	//
    	if(!$this->getUser())
    		return $this->redirectToRoute('app_login');
        
    	// recupère toutes les questions 
    	$questions 	= QcmCollection::_init($this->getDoctrine()->getRepository(Question::class)->findQuestionHaveReponse($category));
    	
    	$current_question 	= $this->session->get("current_question") ?? 0;
    	
    	// end question
    	if($questions->count() <= $current_question){
			$results = QcmCollection::_init($this->getDoctrine()->getRepository(ChoisirReponse::class)->findResults($this->getUser()));
    		
    		$this->session->clear("current_question");// reinitialise question
    		
    		return $this->render('qcm/final.html.twig', [
    			"results_true" 		=> $results->count(),
    			"total_questions"  	=> $questions->count(),
                "category"          => $category,
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
			
			return $this->redirectToRoute('qcm_question', ['libele' => $category->getLibele()]);    	
	    }
        
        //
        return $this->render('qcm/question.html.twig', [
            'reponses' 	=> $reponses,
            'question' 	=> $question,
            'form' 		=> $form->createView()
        ]);
    }

    /**
     * @Route("/result-detail/cat-{libele}", name="qcm_resultdetail")
     */
    public function getDetailResult(ChoisirReponseRepository $cr, Category $category)
    {
        //
        if(!$this->getUser())
            return $this->redirectToRoute('app_login');

        $resultats = $cr->findBy(["user"=> $this->getUser()->getId()]);
        
        return $this->render('qcm/detail.html.twig', [
            "resultats" => $resultats,
            'category'  => $category,
        ]);
    }

    /**
     *@Route("/replay/cat-{libele}", name="qcm_replay")
     */
    public function replayQcm(Category $category)
    {
        
        if(!$this->getUser())
            return $this->redirectToRoute('app_login');
        
        $old_user_answers = $this->getDoctrine()->getRepository(ChoisirReponse::class)->findBy(["user" => $this->getUser()->getId()]);
        
        foreach ($old_user_answers as $answer)
             $this->em->remove($answer);  
       
        $this->em->flush();

        return $this->redirectToRoute('qcm_question', ['libele'=>$category->getLibele()]);
    }
}
