<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\DateType;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;
use App\Entity\Stage;
class StageController extends AbstractController
{


       /**
       * @Route("/admin", name="stage_list")
       * @Method({"GET"})
       */
      public function index() {
        $stages= $this->getDoctrine()->getRepository(Stage::class)->findAll();

        return $this->render('admin/index.html.twig', array('stages' => $stages));
      }
       /**
       * @Route("/admin/new", name="new_stage")
       * @Method({"GET", "POST"})
       */
       public function new(Request $request) {
        $stage = new Stage();
        $form = $this->createFormBuilder($stage)
          ->add('sujet', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('description', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))->add('date_debut',DateType::class, array('attr' => array('class' => 'form-control')))
          ->add('date_fin',DateType::class, array('attr' => array('class' => 'form-control')))
          ->add('profil', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('niveau', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('seuil_select', IntegerType::class, array('attr' => array('class' => 'form-control')))
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
        $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()) {
          $stage = $form->getData();
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($stage);
          $entityManager->flush();
          return $this->redirectToRoute('stage_list');
          }
          return $this->render('admin/new.html.twig', array(
          'form' => $form->createView()
           ));
           }

     /**
     * @Route("/admin/edit/{id}", name="edit_stage")
     * @Method({"GET", "POST"})
     */
      public function edit(Request $request, $id) {
        $stage = new Stage();
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);
        $form = $this->createFormBuilder($stage)
          ->add('sujet', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('description', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))->add('date_debut',DateType::class, array('attr' => array('class' => 'form-control')))
          ->add('date_fin',DateType::class, array('attr' => array('class' => 'form-control')))
          ->add('profil', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('niveau', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('seuil_select', IntegerType::class, array('attr' => array('class' => 'form-control')))
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
          return $this->redirectToRoute('stage_list');
        }
        return $this->render('admin/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }





     /**
     * @Route("/admin/{id}", name="stage_show")
     */
      public function show($id) {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);
        return $this->render('admin/show.html.twig', array('stage' => $stage));
      }

    /**
     * @Route("/admin/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($stage);
        $entityManager->flush();
        $response =new Response();
        $response->send();
    }


     


}
