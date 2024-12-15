<?php

namespace App\Controller;

use App\DTOs\ReservationQueryDTO;
use App\DTOs\ReservationUpdateQueryDTO;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/', name: 'api_reservation_')]
class ReservationApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ReservationRepository $reservationRepository;

    public function __construct(EntityManagerInterface $entityManager, ReservationRepository $reservationRepository)
    {
        $this->entityManager = $entityManager;
        $this->reservationRepository = $reservationRepository;
    }

    #[Route('users/{id}/reservations', name: 'list', methods: ['GET'])]
    public function list(User $user): JsonResponse
    {
        $reservations = $this->reservationRepository->findByUser($user);
        return $this->json($reservations, 200, [], ['groups' => 'reservation:read']);
    }

    #[Route('reservations/{id}', name: 'get', methods: ['GET'])]
    public function get(Reservation $reservation): JsonResponse
    {
        return $this->json($reservation, 200, [], ['groups' => 'reservation:read']);
    }

    #[Route('users/{id}/reservations', name: 'create', methods: ['POST'])]
    public function create(User $user,#[MapRequestPayload] ReservationQueryDTO $reservationDTO): JsonResponse
    {

        $reservation = new Reservation();
        $reservation->setEventName($reservationDTO->eventName);
        $reservation->setDate(new \DateTime($reservationDTO->date->format('Y-m-d H:i:s')));
            $reservation->setTimeSlot($reservationDTO->timeSlot);
        $reservation->setUser($user);

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $this->json($reservation, 201, [], ['groups' => 'reservation:read']);
    }

    #[Route('reservations/{id}', name: 'update', methods: ['PUT'])]
    public function update( #[MapRequestPayload] ReservationUpdateQueryDTO $reservationDTO, Reservation $reservation): JsonResponse
    {

        $reservation->setEventName($reservationDTO->eventName ?? $reservation->getEventName());
        $reservation->setDate(new \DateTime($reservationDTO->date ?? $reservation->getDate()->format('Y-m-d H:i:s')));
        $reservation->setTimeSlot($reservationDTO->timeSlot ?? $reservation->getTimeSlot());

        $this->entityManager->flush();

        return $this->json($reservation, 200, [], ['groups' => 'reservation:read']);
    }

    #[Route('reservations/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Reservation $reservation): JsonResponse
    {
        $this->entityManager->remove($reservation);
        $this->entityManager->flush();

        return $this->json(['message' => 'Reservation deleted successfully'], 204);
    }
}
