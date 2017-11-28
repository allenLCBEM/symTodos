<?php

	namespace AppBundle\Controller;

	use AppBundle\Entity\User;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;

	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;

	use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

	class RegisterController extends Controller
	{
		
		/**
		 * @Route("/register", name="register")
		 * @return \Symfony\Coponent\HttpFoundation\Response
		 */
		public function registerAction(Request $request)
		{
			$user = new User;

			$form = $this->createFormBuilder($user)
				->add('username', TextType::class, 
					array(
						'label' => false, 
						'attr' => array(
							'class' => 'form-control', 
							'style' => 'margin-bottom:10px',
							'placeholder' => 'User Name'
						)
					))
	            ->add('email', EmailType::class, 
	            	array(	            		
	            		'label' => false,
	            		'attr' => array(
	            			'class' => 'form-control', 
							'style' => 'margin-bottom:10px',
	            			'placeholder' => 'Email Address'
	            		)
	            	))
	            ->add('plainPassword', RepeatedType::class, array( 
	                'type' => PasswordType::class,
	                'first_options' => [
	                    'label' => false,
	                    'attr' => array(
	                    	'class' => 'form-control',
	                    	'placeholder' => 'Password'
	                    )
	                ],
	                'second_options' => [
	                    'label' => false,
	                    'attr' => array(
	                    	'class' => 'form-control',
	                    	'placeholder' => 'Confirm Password'
	                    ),
	                ]
	            ))
	            ->add('register', SubmitType::class, array('label' => 'Sign Up', 'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
	            ->getForm();

	        $form->handleRequest($request);

	        if($form->isSubmitted() && $form->isValid()){
	        	$password = $this
	        		->get('security.password_encoder')
	        		->encodePassword(
	        			$user,
	        			$user->getPlainPassword()
	        		);

	        	$user->setPassword($password);

	        	$em = $this->getDoctrine()->getManager();

	        	$em->persist($user);
	        	$em->flush();


	        	$token = new UsernamePasswordToken(
	        		$user,
	        		$password,
	        		'main',
	        		$user->getRoles()
	        	);

	        	$this->get('security.token_storage')->setToken($token);
	        	$this->get('session')->set('_security_main', serialize($token));


	        	$this->addFlash(
	        		'notice', 
	        		'You are now successfully registered!'
	        	);

	        	return $this->redirectToRoute('todo_list');
	        }



			return $this->render('register/register.html.twig', array('form' => $form->createView()));
		}
	}