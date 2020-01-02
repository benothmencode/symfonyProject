<?php

namespace App\Controller;
use App\Entity\Candidat;
use App\Entity\User;
use App\Form\CandidatType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat", name="candidat")
     */
    public function index()
    {

        return $this->render('candidat/index.html.twig', [
            'controller_name' => 'CandidatController',
        ]);

    }


    /**
     * @Route("/candidat/incription", name="candidat_inscrit")
     */
    public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $candidat = new Candidat();
        $form = $this->createForm( CandidatType::class, $candidat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($candidat, $candidat->getPassword());
            $candidat->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidat);
            $entityManager->flush();
            return $this->redirectToRoute('candidat', [
                'id' => $candidat->getId(),
            ]);
        }
        return $this->render('/candidat/form.html.twig',
            array('form' => $form->createView(),'candidat'=>$candidat)
        );
    }

    
    /**
     * @Route("candidat/login", name="logincandidat",methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('candidat/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/candidat/postuler/{id}/{id}", name="postulerstage")
     * @Method({"GET", "POST"})
     */
    public function postuler($idCandidat,$idStage){
        $candidat=new Candidat() ;
        $candidat = $this->getDoctrine()->getRepository(Candidat::class)->find($idCandidat);
        $Stage = $candidat->getStage();



    }


}
