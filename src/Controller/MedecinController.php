<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MedecinController extends AbstractController
{
    #[Route('/medecin', name: 'app_medecin')]
    public function index(): Response
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }

    #[Route('/medecin/list', name: 'app_medecin_list')]
    public function medecinList(MedecinRepository $medecinRepository){
        $medecins= $medecinRepository->findAll();
        return $this->render('medecin/list.html.twig',[
            'medecins' => $medecins
        ]);
    }
    #[Route('/medecin/add', name: 'app_medecin_add')]
    public function medecinAdd(Request $req,EntityManagerInterface $em){
        $med=new Medecin();
        $form= $this->createForm(MedecinType::class, $med);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($med);
            $em->flush();
            return $this->redirectToRoute('app_medecin_list');
        }
        return $this->render('medecin/form.html.twig',[
            'title' => 'Add Medecin',
            'form' => $form
        ]);

    }


    #[Route('/medecin/edit/{id}', name: 'app_medecin_edit')]
    public function medecinedit($id,MedecinRepository $medecinRepository,Request $req,EntityManagerInterface $em){
        $medecin= $medecinRepository->find($id);
        $form= $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_medecin_list');
        }
        return $this->render('medecin/form.html.twig',[
            'title' => 'Update medecin',
            'form' => $form
        ]);
    }

    #[Route('/medecin/delete/{id}', name: 'app_medecin_delete')]
    public function medecinDelete($id,MedecinRepository $medecinRepository,EntityManagerInterface $em){
        $med = $medecinRepository->find($id);
        $em->remove($med);
        $em->flush();
        return $this->redirectToRoute('app_medecin_list');

    }
    #[Route('/medecins/search', name: 'search_medecins')]
    public function searchMedecins(MedecinRepository $medecinRepository): Response
    {
       
        $date1 = new \DateTime('1990-01-01'); 
        $date2 = new \DateTime('2003-12-31'); 

        $medecins = $medecinRepository->findMedecinsEntreDates($date1, $date2);

        return $this->render('medecin/medecinsearch.html.twig',[
            'medecins' => $medecins
        ]);
    }

}
