<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/user", name="user.index")
     */
    public function index()
    {
        $users = $this->repository->findAll();
        
        return $this->render('user/index.html.twig', [
            
            'users' => $users
        ]);
    }

    /**
     * @Route("/user/{id}", name="user.show")
     */
    public function show(User $user)
    {
       
        
        return $this->render('user/show.html.twig', [
            'controller_name' => 'PropertyController',
            
            'user' => $user
        ]);
        
    }

     /**
     * @Route("/user/{id}/edit", name="user.edit")
     */
    public function edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();

            return $this->redirectToRoute('user.index');
        }
        
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/user/create", name="user.create")
    */
    public function create(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setCreatedAt(new \DateTime())
                 ->setUpdatedAt(new \DateTime());   
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/create.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]); 
    }
}
