<?php

namespace App\DTOs;

use Symfony\Component\Validator\Constraints as Assert;

class ReservationUpdateQueryDTO
{

    public function __construct(
            public ?string $eventName = null,

            #[Assert\Type(\DateTimeInterface::class, message: "Invalid date format.")]
            public ?\DateTimeInterface $date = null,

            public ?string $timeSlot = null,

            #[Assert\Type(type: 'integer', message: "User ID must be an integer.")]
            public ?int $userId = null
    )
    {
    }
}