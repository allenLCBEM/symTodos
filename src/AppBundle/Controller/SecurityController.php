<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class SecurityController extends Controller
{
	/**
     * @Route("/login", name="login")
     */
	public function loginAction()
	{
		 //return $this->render('security/login.html.twig');
		// if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
		// 	return $this->redirectToRoute('todo_list');
		// } else {
			return $this->render('security/login.html.twig');
		// }
		
	}

	
	// public function homeAction()
	// {
	// 	if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
	// 		return $this->redirectToRoute('todo_list');
	// 	} else {
	// 		return $this->redirectToRoute('login');
	// 	}
	// }

	/**
     * @Route("/logout")
     */
	public function logoutAction()
	{
		throw new \RuntimeException('This should never be called directly.');
	}
}