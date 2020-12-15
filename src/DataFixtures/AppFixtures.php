<?php

/**
 * @Author: Armel Andrianimanana
 * @Date:   2020-12-15 14:04:04
 * @Last Modified by:   Armel
 * @Last Modified time: 2020-12-15 15:58:33
 */
namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $userPasswordEncoder){
		$this->encoder = $userPasswordEncoder;
	}

    public function load(ObjectManager $manager)
    {
        //
        $users  	= [
        	array(
        		'email' 	=> 'user@user.com', 
        		'password' 	=> 'user@user.com', 
        		'roles' 	=> ['ROLE_USER'], 
        		'username' 	=> 'User'
        	),
        	array(
        		'email' 	=> 'arbandry@gmail.com', 
        		'password' 	=> 'arbandry@gmail.com', 
        		'roles' 	=> ['ROLE_ADMIN', 'ROLE_USER'], 
        		'username' => 'Admin'
        	),
        ]; 
        // user
        foreach ($users as $k => $user) {
        	$user_obj 	= new User();
        	$user_obj
        			->setRoles($user['roles'])
        			->setEmail($user['email'])
        			->setUserName($user['username'])
        			->setPassword($this->encoder->encodePassword($user_obj, $user['password']));
        	$manager->persist($user_obj);		
        }

        // data : category, question, reponse
        $data 	= [
        		"Symfony" => [
		        	array(
		        		'libele' 	=> 'Dans Symfony, la configuration des routes peut être écrite en_____?', 
		        		'countdown' => 30,
		        		'reponses'  => [
		        			['libele' => 'YAML', 'is_true' 	=> false],
		        			['libele' => 'PHP', 'is_true' 	=> false],
		        			['libele' => 'XML', 'is_true' 	=> false],
		        			['libele' => 'Tout les réponses sont vrais', 'is_true' => true],
		        		]	
		        	),
		        	array(
		        		'libele' 	=> 'Lequel des éléments suivants renvoie l\'objet « Response » à l\'utilisateur?', 
		        		'countdown' => 20,
		        		'reponses'  => [
		        			['libele' => 'Bundle', 'is_true' 		=> false],
		        			['libele' => 'Kernel', 'is_true' 		=> false],
		        			['libele' => 'Controller', 'is_true' 	=> false],
		        			['libele' => 'Fixture', 'is_true' 		=> true],
		        		]	
		        	),
		        	array(
		        		'libele' 	=> 'Lequel des éléments suivants contient la logique dont votre application a besoin pour reproduire le contenu d’une page?', 
		        		'countdown' => 60,
		        		'reponses'  => [
		        			['libele' => 'Router', 'is_true' 		=> false],
		        			['libele' => 'Routing', 'is_true' 		=> false],
		        			['libele' => 'Controller', 'is_true' 	=> true],
		        			['libele' => 'Bundle', 'is_true' 		=> false],
		        		]	
		        	),
		        	array(
		        		'libele' 	=> 'L’objet _______ retourné par le contrôleur dans Symfony est toujours le même – Lequel ?', 
		        		'countdown' => 120,
		        		'reponses'  => [
		        			['libele' => 'Response', 'is_true' 		=> true],
		        			['libele' => 'Presentation', 'is_true' 	=> false],
		        			['libele' => 'Request', 'is_true' 		=> false],
		        			['libele' => 'HTML', 'is_true' 			=> false],
		        		]	
		        	)
		        ],
        		"GIT" => [
		        	array(
		        		'libele' 	=> 'Quelle est la commande git qui télécharge votre référentiel de GitHub sur votre ordinateur?', 
		        		'countdown' => 30,
		        		'reponses'  => [
		        			['libele' => 'git push', 'is_true' 	=> false],
		        			['libele' => 'git commit', 'is_true'=> false],
		        			['libele' => 'git fork', 'is_true' 	=> false],
		        			['libele' => 'git clone', 'is_true' => true],
		        		]	
		        	),
		        	array(
		        		'libele' 	=> 'Quelle commande est utilisé pour transférer votre code et vos modifications dans GitHub?', 
		        		'countdown' => 60,
		        		'reponses'  => [
		        			['libele' => '$ git add', 'is_true' 		=> false],
		        			['libele' => '$ git upload', 'is_true' 		=> false],
		        			['libele' => '$ git push', 'is_true' 		=> true],
		        			['libele' => '$ git status', 'is_true' 		=> false],
		        		]	
		        	),
		        	array(
		        		'libele' 	=> 'Comment initialiser le dépôt local avec git?', 
		        		'countdown' => 20,
		        		'reponses'  => [
		        			['libele' => '$ git start', 'is_true' 		=> false],
		        			['libele' => '$ git init', 'is_true' 		=> true],
		        			['libele' => '$ git pull', 'is_true' 		=> false],
		        			['libele' => '$ git clean', 'is_true' 		=> false],
		        		]	
		        	),
		        	array(
		        		'libele' 	=> 'Comment récupérez du code d’un autre repository sur GitHub?', 
		        		'countdown' => 50,
		        		'reponses'  => [
		        			['libele' => 'Forking via l’interface GitHub.', 'is_true' 	=> true],
		        			['libele' => '$ git pull-request', 'is_true' 				=> false],
		        			['libele' => '$ git fork', 'is_true' 						=> false],
		        			['libele' => '$ git clone', 'is_true' 						=> false],
		        		]	
		        	)
		        ]
        ];

        //
        foreach ($data as $k => $category) {
        	
        	// category
        	$obj_category 	= new Category();
        	$obj_category->setLibele($k);
        	$manager->persist($obj_category);

        	// question
        	$index_question = 1;
        	foreach ($category as $question) {
        		$obj_question 	= new Question(); 
        		$obj_question 
        					->setLibele($question['libele'])
        					->setCountdown($question['countdown'])
        					->setIndexQuestion($index_question)
        					->setCategory($obj_category);        		
        		$manager->persist($obj_question);

        		//reponse possible
        		foreach ($question['reponses'] as $reponse) {
        			$obj_reponse = new Reponse();
        			$obj_reponse
        						->setLibele($reponse['libele'])
        						->setIsTrue($reponse['is_true'])
        						->setQuestion($obj_question);

        			$manager->persist($obj_reponse);
				}	

        		$index_question++;			
        	}
        }

        $manager->flush();
    }
}
