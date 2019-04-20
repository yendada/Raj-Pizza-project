<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;   
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use DateTimeInterface;


class Display extends AbstractController
{
	private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
	
	
    /**
     * @Route("/displayDriver", name="display_driver") methods={"GET", "POST"}
     */
	 
    public function displayDriverOrders(SessionInterface $session)
    {	
		$repo = $this->getDoctrine()->getRepository(Orders::class);
			
		$orders = $repo->findBy(['status' => 'pending']);
		
		if (!$orders) {
			throw $this->createNotFoundException(
				'No orders found '
			);
		}
		
		else 
		{
			return $this->render('orders/driverOrders.html.twig', ['orders'=>$orders]);
		}
		
		
	}	
	
	
	/**
     * @Route("/displayCustomer", name="display_customer") methods={"GET", "POST"}
     */
	public function displayCustomerOrders(SessionInterface $session)
    {	
		$request = Request::createFromGlobals(); // the envelope, and were looking inside it.
		
		$placedby = $session->get('username');
				
		$repo = $this->getDoctrine()->getRepository(Orders::class);
			
		$ordersCust = $repo->findBy(['placedby' => $placedby]);
		
		if (!$ordersCust) {
			throw $this->createNotFoundException(
				'No orders found for '.$placedby
			);
		}
		
		else 
		{
			return $this->render('orders/customerOrders.html.twig', ['orders'=>$ordersCust]);
		}
		
		
	}
		
	
    /**
     * @Route("/displayManager", name="display_manager") methods={"GET", "POST"}
     */
	 
    public function displayManagerOrders(SessionInterface $session)
    {	
		$repo = $this->getDoctrine()->getRepository(Orders::class);
			
		$orders = $repo->findAll();
		
		if (!$orders) {
			throw $this->createNotFoundException(
				'No orders found '
			);
		}
		
		else 
		{
			return $this->render('orders/managerOrders.html.twig', ['orders'=>$orders]);
		}
		
		
	}
	
	
	/**
     * @Route("/delivered", name="delivered") methods={"GET", "POST"}
     */
	public function markDelivered(SessionInterface $session)
    {	
		$request = Request::createFromGlobals(); 
		
		$entityManager = $this->getDoctrine()->getManager();
		
		// get the variable
		$orderID = $request->request->get('id', 'none');
		$repo = $this->getDoctrine()->getRepository(Orders::class);
			
		$order = $repo->findOneBy(['id' => $orderID]);
		
		if (!$order) {
			throw $this->createNotFoundException(
				'No orders found for '.$orderID
			);
		}
		
		$order->setStatus('Delivered');
		
		$entityManager->persist($order);
		
		$entityManager->flush();
		
		
		$orders = $repo->findBy(['status' => 'pending']);
		
		if (!$orders) {
			throw $this->createNotFoundException(
				'No orders found '
			);
		}
		
		else 
		{
			return $this->render('orders/driverOrders.html.twig', ['orders'=>$orders] );
		}
	}
	
	/**
     * @Route("/delete", name="delete") methods={"GET", "POST"}
     */
	public function deleteOrder(SessionInterface $session)
    {	
		$request = Request::createFromGlobals(); 
		
		$orderID = $request->request->get('id', 'none');
		
		$entityManager = $this->getDoctrine()->getManager();
		
		$order = $entityManager->getRepository(Orders::class)->find($orderID);
		
		
		if (!$order) {
			throw $this->createNotFoundException(
				'No orders found for '.$orderID
			);
		}
		
		$entityManager->remove($order);
		
		$entityManager->flush();
		
		$repo = $this->getDoctrine()->getRepository(Orders::class);
		
		$orders = $repo->findAll();
		
		return $this->render('orders/managerOrders.html.twig', ['orders'=>$orders]);
	}
	
		
	/**
     * @Route("/total", name="totalReport") methods={"GET", "POST"}
     */
	public function totalReport(SessionInterface $session)
    {	
		
		$manager = $this->getDoctrine()
			->getRepository(Orders::class)
			->findTotalOrderdAndRevenue();
		
		return $this->render('orders/managerReports.html.twig', ['orders'=>$manager]);
	}
	
	
}