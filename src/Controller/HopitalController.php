<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Form\HopitalType;
use App\Repository\HopitalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HopitalController extends AbstractController
{
    #[Route('/hopital', name: 'app_hopital')]
    public function index(): Response
    {
        return $this->render('hopital/index.html.twig', [
            'controller_name' => 'HopitalController',
        ]);
    }

    
    #[Route('/hopital/list', name: 'app_hopital_list')]
    public function hoptialList(HopitalRepository $hopitalRepository){
        $hopitals= $hopitalRepository->findAll();
        return $this->render('hopital/list.html.twig',[
            'hopitals' => $hopitals
        ]);
    }
    #[Route('/hopital/add', name: 'app_hopital_add')]
    public function hopitalAdd(Request $req,EntityManagerInterface $em){
        $hpt=new Hopital();
        $form= $this->createForm(HopitalType::class, $hpt);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($hpt);
            $em->flush();
            return $this->redirectToRoute('app_hopital_list');
        }
        return $this->render('hopital/form.html.twig',[
            'title' => 'Add Hopital',
            'form' => $form
        ]);

    }


    #[Route('/hopital/edit/{id}', name: 'app_hopital_edit')]
    public function hoptailedit($id,HopitalRepository $hopitalRepository,Request $req,EntityManagerInterface $em){
        $hpt= $hopitalRepository->find($id);
        $form= $this->createForm(HopitalType::class, $hpt);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_hopital_list');
        }
        return $this->render('hopital/form.html.twig',[
            'title' => 'Update hopital',
            'form' => $form
        ]);
    }

    #[Route('/hopital/delete/{id}', name: 'app_hopital_delete')]
    public function medecinDelete($id,HopitalRepository $hopitalRepository,EntityManagerInterface $em){
        $hpt = $hopitalRepository->find($id);
        $em->remove($hpt);
        $em->flush();
        return $this->redirectToRoute('app_hopital_list');

    }
}
