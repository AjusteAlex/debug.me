<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tickets')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findAll();

        if (!empty($tickets)) {
            foreach ($tickets as $ticket) {
                $isAuthor = $this->isAuthor($ticket);
            }
        } else {
            $isAuthor = false;
        }

        return $this->render('ticket/index.html.twig', ['tickets' => $ticketRepository->findAll(), 'isAuthor' => $isAuthor]);
    }

    private function isAuthor(Ticket $ticket): ?bool
    {
        $user = $this->getUser();
        if (null !== $user) {
            if ($ticket->getAuthor()->getId() === $user->getId()) {
                return true;
            } else {
                return false;
            }
        }

        return null;
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $datetime = new \DateTimeImmutable();

                $user = $this->getUser();
                $userScore = $user->getScore();
                $user->setScore($userScore + 1);

                $ticket->setAuthor($user);
                $ticket->setCreatedAt($datetime);

                $entityManager->persist($ticket);
                $entityManager->flush();

                return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('ticket/new.html.twig', ['ticket' => $ticket, 'form' => $form]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket, UserRepository $userRepository): Response
    {
        $author = $userRepository->findOneBy(['id' => $ticket->getAuthor()]);

        return $this->render('ticket/show.html.twig', ['ticket' => $ticket, 'author' => $author, 'isAuthor' => $this->isAuthor($ticket)]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/edit.html.twig', ['ticket' => $ticket, 'form' => $form, 'isAuthor' => $this->isAuthor($ticket)]);
    }

    #[Route('/{id}/solve', name: 'app_ticket_solve', methods: ['GET', 'POST'])]
    public function solve(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isAuthor($ticket)) {
            $ticket->isSolved() ? $ticket->setSolved(false) : $ticket->setSolved(true);

            $user = $this->getUser();
            $userScore = $user->getScore();
            $user->setScore($userScore + 2);

            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            if ($this->isAuthor($ticket)) {
                $entityManager->remove($ticket);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
