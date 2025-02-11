<?php

namespace App\Controller;

use App\Entity\Carta;
use App\Entity\Usuario;
use App\Repository\CartaRepository;
use App\Form\ChangePasswordFormType;
use App\Form\ProfilePictureFormType;
use App\Form\ProfileUsernameFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(): Response
    {
        /** @var Usuario $user */
        $user = $this->getUser();
        return $this->render('pages/profile.html.twig', [
            'username' => $user->getUsername(),
            'imagen' => $user->getImagen(),
        ]);
    }

    #[Route('/edit-picture', name: 'app_edit_profile_picture')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editProfilePicture(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Usuario $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfilePictureFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imagen')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('profile_pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error uploading the file.');
                    return $this->redirectToRoute('app_edit_profile_picture');
                }

                // Remove old profile image if exists
                if ($user->getImagen()) {
                    $oldImagePath = $this->getParameter('profile_pictures_directory') . '/' . $user->getImagen();
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Update user entity
                $user->setImagen($newFilename);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Profile picture updated successfully.');
                return $this->redirectToRoute('app_profile');
            }
        }

        return $this->render('pages/edit-profile-picture.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit-username', name: 'app_edit_profile_username')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editProfileUsername(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Usuario $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfileUsernameFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Username updated successfully.');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('pages/edit-profile-username.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/my-cards', name: 'app_user_cards')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function userCards(CartaRepository $cartaRepository): Response
    {
        /** @var Usuario $user */
        $user = $this->getUser();
        $cartas = $cartaRepository->findBy(['usuario' => $user]);

        return $this->render('pages/my-cards.html.twig', [
            'cartas' => $cartas,
        ]);
    }

    #[Route('/delete-card/{id}', name: 'app_delete_card', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteCard(Carta $carta, Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();

        if ($carta->getUsuario() !== $user) {
            $this->addFlash('error', 'No puedes eliminar esta carta.');
            return $this->redirectToRoute('app_user_cards');
        }

        $token = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete_card_' . $carta->getId(), $token))) {
            $this->addFlash('error', 'Token CSRF inválido.');
            return $this->redirectToRoute('app_user_cards');
        }

        $entityManager->remove($carta);
        $entityManager->flush();

        $this->addFlash('success', 'Carta eliminada con éxito.');
        return $this->redirectToRoute('app_user_cards');
    }

    #[Route('/change-password', name: 'app_change_password')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function changePassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        /** @var Usuario $user */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();

            // Check if the current password is correct
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Current password is incorrect.');
                return $this->redirectToRoute('app_change_password');
            }

            // Hash the new password and save
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);
            $entityManager->flush();

            $this->addFlash('success', 'Password changed successfully.');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('pages/change-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
