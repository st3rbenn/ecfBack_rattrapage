<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="app_user_profile")
     */
    public function index(): Response
    {

        return $this->render('user_profile/index.html.twig', [
            'app_profile' => 'app_profile'
        ]);
    }

    /**
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
}
