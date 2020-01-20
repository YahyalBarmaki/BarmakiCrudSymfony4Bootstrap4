<?php

namespace App\Controller;
use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/inscris",name="inscris",methods={"POST"})
     */
    public function inscris(Request $request,UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username,$values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(["ROLE_ADMIN"]);

            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status'=>201,
                'message'=>'L\'utilisateur a été créé'
            ];
            return new JsonResponse($data,201);
        }
        $data = [
            'status'=>500,
            'message'=>'Vous devez renseigner les clés username et password'
        ];
        return new jsonResponse($data,500);

    }
/**
 * @Route("/login",name="login", methods="{POST}")
 */
    public function login(Request $request)
        {
             $user = $this->getUser();
             return $this->json([
                 'username'=>$user->getUserName(),
                 'roles'=>$user->getRoles()
             ]);
        }
}
