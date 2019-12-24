<?php

namespace App\Controller;
use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialiteController extends AbstractController
{
   

    //affichage de l'ensemble des specialites
   /**
    * @Route("/specialite/show", name="specialite.specialite.show")
     */
    public function showSpecialite(SpecialiteRepository $repos)
    {
        $specialites = $repos->findAll();
        return $this->render('specialite/index.html.twig', [
            'specialites'=>$specialites
            
        ]);
    }

//fin affichage de l'ensemble des specialites
//formulaire d'ajout de specialite
   /**
    * @Route("/specialite/add", name="specialite.specialite.add")
     */
    public function addSpecialite( Request $request)
    {
    
    
        $specialite = new Specialite();

    $form = $this->createForm(SpecialiteType::class, $specialite);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialite);
        $entityManager->flush();

       return $this->redirectToRoute('specialite.specialite.show');
   
   }
   return $this->render('specialite/form.html.twig', [
       'form' => $form->createView(),
   ]);


}
//fin insertion
//debut modification
   /**
    * @Route("/specialite/edit{id}", name="specialite.specialite.edit")
     */
    
    public function editSpecialite($id, Request $request,SpecialiteRepository $repos )
    {
    
    
    $specialite=$repos->find($id);

    $form = $this->createForm(SpecialiteType::class, $specialite);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialite);
        $entityManager->flush();

       return $this->redirectToRoute('specialite.specialite.show');
   
   }
   return $this->render('specialite/form.html.twig', [
       'form' => $form->createView(),
   ]);


}
//fin modification et debut suppression

   /**
    * @Route("/specialite/delete{id}", name="specialite.specialite.delete")
     */
    
    public function deleteSpecialite($id, SpecialiteRepository $repos )
    {
    
    
    $specialite=$repos->find($id);
    $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($specialite);
         $entityManager->flush();

        return $this->redirectToRoute('specialite.specialite.show');
    
    }


}
