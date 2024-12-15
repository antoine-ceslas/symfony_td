<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // Create Admin User
        $adminUser = new User();
        $adminUser->setEmail('admin@example.com');
        $adminUser->setName('adminUser');
        $adminUser->setPhoneNumber('1234567890');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPassword(
            $this->passwordHasher->hashPassword($adminUser, 'admin123') // Use a secure password
        );
        $manager->persist($adminUser);

        // Create Regular User
        $regularUser = new User();
        $regularUser->setEmail('user@example.com');
        $regularUser->setName('user');
        $regularUser->setPhoneNumber('1234567890');
        $regularUser->setRoles(['ROLE_USER']);
        $regularUser->setPassword(
            $this->passwordHasher->hashPassword($regularUser, 'user123') // Use a secure password
        );
        $manager->persist($regularUser);

        // Save changes
        $manager->flush();
    }
}
