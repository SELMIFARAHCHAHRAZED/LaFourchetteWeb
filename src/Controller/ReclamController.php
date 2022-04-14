<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclam;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReclamType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReclamController extends AbstractController
{
    /**
     * @Route("/reclam", name="app_reclam")
     */
    public function index(): Response
    {
        $reclams = $this->getDoctrine()->getRepository(Reclam::class)->findAll();
        return $this->render('reclam/index.html.twig', [
            'reclams' => $reclams,
        ]);
    }
     /**
     * @Route("/deleteReclam/{id}", name="deleteReclam")
     */
    public function deleteReclam($id)
    {
        $reclam = $this->getDoctrine()->getRepository(Reclam::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclam);
        $em->flush();
        return $this->redirectToRoute("app_reclam");
    }

     /**
     * @Route("/addReclam", name="addReclam")
     */
    public function addReclam(Request $request)
    {
        $reclam = new Reclam();
        $form = $this->createForm(ReclamType::class, $reclam);
        //$form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclam);
            $em->flush();
           // return $this->redirectToRoute('app_reclam');
            return $this->render("Front/Front-base.html.twig");
        }
        return $this->render("reclam/ADD_Reclam.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/updateReclam/{id}", name="updateReclam")
     */
    public function updateReclam(Request $request,$id)
    {
        $reclam = $this->getDoctrine()->getRepository(Reclam::class)->find($id);
        $form = $this->createForm(ReclamType::class, $reclam);
        $form->add('modifier',SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_reclam');
        }
        return $this->render("reclam/update.html.twig",array('form'=>$form->createView()));
    }
}
