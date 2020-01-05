<?php

namespace App\Controller;
use App\Entity\Candidat;
use App\Entity\Stage;
use App\Entity\User;
use App\Form\CandidatType;

use App\Repository\StageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CandidatController extends AbstractController
{

    /**
     * @Route("/candidat", name="candidat",methods={"GET", "POST"})
     */
    public function index(PaginatorInterface $paginator , Request $request) {

        $stages=$paginator->paginate(
            $this->repository->findAllVisible(),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('/candidat/index.html.twig', array('stages' => $stages));
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
     * @Route("/candidat/incription", name="candidat_inscrit",methods={"GET", "POST"})
     */
    public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $candidat = new Candidat();
        $form = $this->createForm( CandidatType::class, $candidat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($candidat, $candidat->getPassword());
            $candidat->setPassword($password);

            $imageFile = $form['photo']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the jpg file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $candidat->setPhoto($newFilename);
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidat);
            $entityManager->flush();
            return $this->redirectToRoute('logincandidat'
            );
        }
        return $this->render('/candidat/form.html.twig',
            array('form' => $form->createView(),'candidat'=>$candidat)
        );
    }

    private $repository;
    public function __construct(StageRepository $repository)
    {
        $this->repository=$repository;
    }



//    /**
//     * @Route("/candidat/{username}", name="candidat")
//     */
//    public function userAccount(Candidat $candidat)
//    {
//
//        return $this->render('candidat/userAccount.html.twig',
//            ['candidat'=>$candidat]
//        );
//
//    }
//
//    /**
//     * @Route("/candidat/postuler/{id}/{id}", name="postulerstage",methods={"GET", "POST"})
//     */
//    public function postuler($idCandidat,$idStage){
//        $candidat=new Candidat() ;
//        $candidat = $this->getDoctrine()->getRepository(Candidat::class)->find($idCandidat);
//        $Stage = $candidat->getStage();
//
//
//
//    }

    /**
     * @Route("/candidat/postuler/{idCandidat}/{idStage}", name="postulerstage",methods={"GET", "POST"})
     */
    public function postuler(Request $request ,$idCandidat,$idStage){

        $candidat = $this->getDoctrine()->getRepository(Candidat::class)->find($idCandidat);
        $stage=$this->getDoctrine()->getRepository(Stage::class)->find($idStage);
        $form = $this->createFormBuilder($candidat)

            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $stage->addCandidat($candidat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('candidat');
        }
        return $this->render('candidat/postuler.html.twig', array(
            'form' => $form->createView() ,
            'stage' => $stage
        ));
    }


}
