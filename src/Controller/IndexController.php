<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
       
        return $this->render('index.html.twig');
    }
	
	
	public function getUserID()
    {
        // STEPS
        // 1. make the function - done
        // 2. connect to the db
        // 3. select the record
        // 4. return the record
				
		// Search for the person with the ID 1
		$person = $this->getDoctrine()
        ->getRepository(Login::class) // the type of the entity
        ->findOneBy([
                'name' => 'raj',
			
                ]);; // ID number of the row in the database table.	
		return $person->getId();
    }
	
	
	
	public function getANumber(){
   
		return 27;
    }
	
	
	
	
	
	
	
	
}