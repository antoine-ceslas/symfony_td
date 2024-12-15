<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'user_profile')]
    public function viewProfile(): Response
    {
        $user = $this->getUser(); // Get the currently logged-in user
        if (!$user) {
            throw $this->createAccessDeniedException('You are not logged in.');
        }

        return $this->render('profile/view.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/edit', name: 'user_profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Get the currently logged-in user
        if (!$user) {
            throw $this->createAccessDeniedException('You are not logged in.');
        }

        $form = $this->createForm(UserType::class, $user,['is_admin' => false,'is_create'=>false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Your profile has been updated successfully.');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
