<?php

namespace App\Controller;

use App\DTOs\UserQueryDTO;
use App\DTOs\UserUpdateQueryDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users', name: 'api_users_')]
class UserApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        return $this->json($users, 200, [], ['groups' => 'user:read']);
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(User $user): JsonResponse
    {
        return $this->json($user, 200, [], ['groups' => 'user:read']);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create( #[MapRequestPayload] UserQueryDTO $userDto): JsonResponse
    {

        $user = new User();
        $user->setEmail($userDto->email);
        $user->setName($userDto->name);
        $user->setPhoneNumber($userDto->phoneNumber);
        $user->setRoles($userDto->roles);
        $user->setPassword(password_hash($userDto->password, PASSWORD_BCRYPT));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($user, 201, [], ['groups' => 'user:read']);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update( #[MapRequestPayload] UserUpdateQueryDTO $userDto, User $user): JsonResponse
    {
        /*$data = json_decode($request->getContent(), true);*/

        $user->setName($userDto->name?? $user->getName());
        $user->setPhoneNumber($userDto->phoneNumber ?? $user->getPhoneNumber());
        $user->setRoles($userDto->roles ?? $user->getRoles());

        $this->entityManager->flush();

        return $this->json($user, 200, [], ['groups' => 'user:read']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'User deleted successfully'], 204);
    }
}
