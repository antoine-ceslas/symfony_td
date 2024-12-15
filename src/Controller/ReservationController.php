<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class ReservationController extends AbstractController
{
    #[Route('users/{id}/reservations',name: 'user_reservations_list', methods: ['GET'])]
    public function index(User $user,ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findByUser($user),
            'user' =>  $user,
        ]);
    }


    #[Route('users/{id}/reservations/new', name: 'user_reservations_new', methods: ['GET', 'POST'])]
    public function new(User $user,Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            $user=$reservation->getUser()->id;
            return $this->redirectToRoute('user_reservations_list', ['id'=>$user->id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'user' =>  $user,
        ]);
    }

    #[Route('/reservations/{id}', name: 'user_reservations_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'user' =>  $reservation->getUser(),
        ]);
    }

    #[Route('/reservations/{id}/edit', name: 'user_reservations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $user=$reservation->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_reservations_list', ['id'=>$user->id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'user'=>$user
        ]);
    }

    #[Route('/reservations/{id}', name: 'user_reservations_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $user=$reservation->getUser();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_reservations_list', ['id'=>$user->id], Response::HTTP_SEE_OTHER);
    }
}
