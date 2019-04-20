<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;   
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class Backend extends AbstractController
{
    
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    
    
    /**
     * @Route("/backend", name="catch") methods={"GET","POST"}
     */
	 
    public function index(SessionInterface $session)
    {
        $request = Request::createFromGlobals(); // the envelope, and were looking inside it.
        $type = $request->request->get('type', 'none'); // to send ourself in different directions
        
        if($type == 'register'){
			
			// get the username and password
            $username = $request->request->get('username', 'none');
            
            $repo = $this->getDoctrine()->getRepository(Login::class);
            $person = $repo->findOneBy([ 'username' => $username ]);
			
			if ($person) {
				return new Response(
					'exists'
				);
				
			}
			else {
			
				// perform register process
				
				// get the variables
				$username = $request->request->get('username', 'none');
				$password = $request->request->get('password', 'none');
				$acctype = $request->request->get('acctype', 'none');
							
				// put in the database            
				$entityManager = $this->getDoctrine()->getManager();
				$login = new Login();
				$login->setUsername($username);
				$login->setPassword($password);
				$login->setAcctype($acctype);
				 
				$entityManager->persist($login);
				// actually executes the queries (i.e. the INSERT query)
				$entityManager->flush();             
							
				return new Response(
					'register page was called!'
				);
			}
        }
        else if($type == 'login'){ // if we had a login
            
            
            // get the username and password
            $username = $request->request->get('username', 'none');
            $password = $request->request->get('password', 'none');
            
            
             $repo = $this->getDoctrine()->getRepository(Login::class); // the type of the entity
             
             
             $person = $repo->findOneBy([
                'username' => $username,
                'password' => $password,
                ]);
                // save the user ID to the session
                // KEY-VALUE
                
                // KEY - IS the name we give it
                // $variable - is what we want to save.
               $session->set('username', $username);
               
                return new Response(
                    $person->getAcctype()
                    );               
        }
        else if($type == 'getusername'){
            // send back a response, with the username we stored in the session.
            return new Response( $session->get('username'));
        
        }
         
                return new Response(
                    'all ok'
                    );       
        
        
    }
    
    
}