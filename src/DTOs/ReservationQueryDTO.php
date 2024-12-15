<?php

namespace App\DTOs;

use Symfony\Component\Validator\Constraints as Assert;
class ReservationQueryDTO
{

    public function __construct(
            #[Assert\NotBlank(message: "Event name should not be blank.")]
            public ?string $eventName = null,

            #[Assert\NotBlank(message: "Date should not be blank.")]
            #[Assert\Type(\DateTimeInterface::class, message: "Invalid date format.")]
            public ?\DateTimeInterface $date = null,

            #[Assert\NotBlank(message: "Time slot should not be blank.")]
            public ?string $timeSlot = null,

            #[Assert\NotBlank(message: "User ID should not be blank.")]
            #[Assert\Type(type: 'integer', message: "User ID must be an integer.")]
            public ?int $userId = null
    )
    {
    }
}