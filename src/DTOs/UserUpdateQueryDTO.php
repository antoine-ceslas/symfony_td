<?php

namespace App\DTOs;

use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateQueryDTO
{
    public function __construct(
        #[Assert\Email(message: "Invalid email format.")]
        public ?string $email = null,
        public ?string $name = null,

        #[Assert\Length(min: 8, minMessage: "Password must be at least 8 characters.")]
        public ?string $password = null,

        #[Assert\Type('array', message: "Roles must be an array.")]
        public ?array $roles = [],
        #[Assert\Regex('/^\+?[0-9]{7,15}$/', message: "Phone number must be valid.")]
        public ?string $phoneNumber = null,
    )
    {
    }

}
