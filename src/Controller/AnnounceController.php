<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\AnnounceType;
use App\Repository\AnnounceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnounceController extends AbstractController
{
    
    #[Route('/announces', name: 'announce_index')]
    public function index(AnnounceRepository $announceRepository): Response
    {
        return $this->render('announce/index.html.twig', [
            "announces" => $announceRepository->findAll()
        ]);
    }

    #[Route('/announces/new', name: 'announces_new')]
    public function new(Request $request): Response
    {
        $announce = new Announce();
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $coverImage = $form->get('coverImage')->getData();

            if($coverImage)
            {
                $imageName = md5(uniqid()) . '.' . $coverImage->guessExtension();

                $coverImage->move(
                    $this->getParameter('photos_directory'),
                    $imageName
                );
            }
             $em = $this->getDoctrine()->getManager();

             $em->persist($announce);
             $em->flush();


             return $this->redirectToRoute('announce_index');
            
        }
        return $this->render('announce/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/announces/{id}/edit', name: 'announce_edit')]
    public function edit(Announce $announce, Request $request): Response
    {
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('announce_index');
        }
        return $this->render('announce/edite.html.twig', [
        "form" => $form->createView() 
        ]);
    }



    // fonction pour supprimer une annonce
    /**
     * @Route("/announces/{id}/delete", name="announce_delete")
     * @param Announce $announce
     * @return RedirectResponse
     */
    public function delete(Announce $announce): RedirectResponse
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($announce);
        $em->flush();
        
        return $this->redirectToRoute('announce_index');
    }

    // fonction pour afficher les détaile de l'annonce
    #[Route('/{id}/show', name: 'announce_show')]
    public function show(int $id, Announce $announce): Response
    {
        $comments = $announce->getComments();
        return $this->render('announce/show.html.twig', [
            "announces" => $announce,
            "comments" => $comments
        ]);
    }

    #[Route('/admin', name: 'announce_admin')]
    public function admin(AnnounceRepository $announceRepository): Response
    {
        return $this->render('admin/admin.html.twig', [
            "announces" => $announceRepository->findAll()
        ]);
    }
}
