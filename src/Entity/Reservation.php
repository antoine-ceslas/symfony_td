<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\UniqueConstraint(name: "unique_date_time_slot", columns: ["date", "time_slot"])]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation:read'])]
    private ?int $id = null;

    #[Assert\GreaterThan("+1 day", message: "Reservations must be made at least 24 hours in advance.")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reservation:read'])]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(length: 255)]
    #[Groups(['reservation:read'])]
    private ?string $eventName = null;
    #[ORM\Column(length: 255)]
    #[Groups(['reservation:read'])]
    private ?string $timeSlot = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[Groups(['reservation:read'])]
    private ?User $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }


    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): static
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getTimeSlot(): ?string
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(string $timeSlot): static
    {
            $this->timeSlot = $timeSlot;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
