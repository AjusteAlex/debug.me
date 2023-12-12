<?php

namespace App\Controller;

use App\Entity\Gamification;
use App\Form\GamificationType;
use App\Repository\GamificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamificationController extends AbstractController
{
    #[Route('/badges', name: 'app_gamifications')]
    public function index(GamificationRepository $gamification): Response
    {
        $gamification = $gamification->findAll();
                
        return $this->render('gamification/index.html.twig', [
            'gamifications' => $gamification,
        ]);
    }

    #[Route('/badge/new', name: 'app_new_gamification')]
    public function new(HttpFoundationRequest $request, EntityManagerInterface $entityManager): Response
    {

        $gamification = new Gamification();
        $form = $this->createForm(GamificationType::class, $gamification);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['picture']->getData(); // Récupère l'image du formulaire

            if ($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('photos_directory'), $fileName);
                $gamification->setPicture($fileName);
            }
        
            $entityManager->persist($gamification);
            $entityManager->flush();
            return new Response("User photo is successfully uploaded."); 
        }

        return $this->render('gamification/new.html.twig', ['form' => $form]);
    }
}
