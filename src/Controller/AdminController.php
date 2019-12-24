<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
//affichage de l'ensemble des services
   /**
    * @Route("/admin", name="admin.service.show")
     */
    public function showService(ServiceRepository $repos)
    {
        $services = $repos->findAll();
        return $this->render('admin/index.html.twig', [
            'services'=>$services
            
        ]);
    }


//creation de notre page d'aceuille

    /**
     * @Route("/", name = "home")
     */
    public function home(){
        return $this->render('admin/home.html.twig',[
            'title'=> "BIENVENUE LES AMIS!"
            
        ]);
    }

//formulaire d'ajout de service
   /**
    * @Route("/admin/add", name="admin.service.add")
     */
   public function addService( Request $request)
    {
    
    
    $service = new Service();

    $form = $this->createForm(ServiceType::class, $service);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
        $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($service);
         $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    
    }
    return $this->render('admin/form.html.twig', [
        'form' => $form->createView(),
    ]);


}

//modification

   /**
    * @Route("/admin/edit{id}", name="admin.service.edit")
     */
    
    public function editService($id, Request $request,ServiceRepository $repos )
    {
    
    
    $service=$repos->find($id);

    $form = $this->createForm(ServiceType::class, $service);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
        $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($service);
         $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    
    }
    return $this->render('admin/form.html.twig', [
        'form' => $form->createView(),
    ]);


}



   /**
    * @Route("/admin/delete{id}", name="admin.service.delete")
     */
    
    public function deleteService($id, ServiceRepository $repos )
    {
    
    
    $service=$repos->find($id);
    $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($service);
         $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    
    }










}
