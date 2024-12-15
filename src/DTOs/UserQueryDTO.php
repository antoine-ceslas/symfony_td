<?php

namespace App\DTOs;

use Symfony\Component\Validator\Constraints as Assert;

class UserQueryDTO
{
    public function __construct(
        #[Assert\NotBlank(message: "Email should not be blank.")]
        #[Assert\Email(message: "Invalid email format.")]
        public ?string $email = null,
        #[Assert\NotBlank(message: "Name should not be blank.")]
        public ?string $name = null,

        #[Assert\NotBlank(message: "Password should not be blank.")]
        #[Assert\Length(min: 8, minMessage: "Password must be at least 8 characters.")]
        public ?string $password = null,

        #[Assert\NotBlank(message: "Roles should not be blank.")]
        #[Assert\Type('array', message: "Roles must be an array.")]
        public ?array $roles = [],

        #[Assert\NotBlank(message: "Phone number should not be blank.")]
        #[Assert\Regex('/^\+?[0-9]{7,15}$/', message: "Phone number must be valid.")]
        public ?string $phoneNumber = null,
    )
    {
    }

}
