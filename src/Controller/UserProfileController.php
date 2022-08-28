<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UpdatePasswordType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/profile", name="app_user_profile")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        return $this->render('user_profile/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/update", name="app_user_profile_update")
     */
    public function updateAccount(
        Request $request,
        userPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository
    ): Response
    {
        $user = $userRepository->find($this->getUser());
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $userRepository->upgradePassword($user, $passwordHasher->hashPassword($user, $user->getPassword()));

            $this->addFlash('success', 'Vos informations ont bien été modifiées');
            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user_profile/update.html.twig', [
            'editProfile' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/update/pass", name="app_user_profile_update_password")
     */
    public function updatePassword(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserRepository $userRepository
    ): Response
    {
        $user = $userRepository->find($this->getUser());
        $form = $this->createForm(UpdatePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $userRepository->upgradePassword($user, $userPasswordHasher->hashPassword($user, $user->getPassword()));

            $this->addFlash('success', 'Votre mot de passe a bien été modifié');
            return $this->redirectToRoute('app_user_profile');
        }
        return $this->render('user_profile/update_password.html.twig', [
            'editPassword' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/delete", name="app_user_profile_delete")
     */
    public function deleteAccount(
        UserRepository $userRepository
    ): Response
    {
        $user = $userRepository->find($this->getUser());
        if($userRepository->remove($user)){
            $this->addFlash('success', 'Votre compte a bien été supprimé');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user_profile/delete.html.twig', [
            'deleteAccount' => 'deleteAccount',
        ]);
    }
}
