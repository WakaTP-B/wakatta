<?php

namespace App\Controller;

use App\Form\DeleteAccountFormType;
use App\Form\EditProfileFormType;
use App\Form\UsernameFormType;
use App\Repository\ActivityRepository;
use App\Repository\XpTransactionRepository;
use App\Service\AccountDeleter;
use App\Service\AccountEditor;
use App\Service\LevelCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfileController extends AbstractController
{
    private const MODULE_LABELS = [
        'QCM Vocabulaire' => ['label' => 'Vocabulaire'],
        'Hiragana Calligraphie' => ['label' => 'Hiragana - Calligraphie'],
        'Hiragana Complétion' => ['label' => 'Hiragana - Complétion'],
        'Hiragana Assemblage' => ['label' => 'Hiragana - Assemblage'],
    ];

    #[Route('/profil', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(
        XpTransactionRepository $xpTransactionRepository,
        ActivityRepository $activityRepository,
        LevelCalculator $levelCalculator,
    ): Response {
        $user = $this->getUser();

        $xpTotal = $xpTransactionRepository->getTotalXpForUser($user);
        $globalProgression = $levelCalculator->calculProgress($xpTotal);

        $modules = [];
        foreach ($activityRepository->findAll() as $activity) {
            $config = self::MODULE_LABELS[$activity->getName()] ?? ['label' => $activity->getName()];

            $xpForActivity = $xpTransactionRepository->getTotalXpActivityForUser($user, $activity);

            $modules[] = [
                'label' => $config['label'],
                'progression' => $levelCalculator->calculProgress($xpForActivity),
            ];
        }

        return $this->render('profile/index.html.twig', [
            'globalProgression' => $globalProgression,
            'modules' => $modules,
        ]);
    }

    #[Route('/profil/modifier', name: 'app_profile_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(): Response
    {
        return $this->render('profile/edit.html.twig', [
            'deleteAccountForm' => $this->createForm(DeleteAccountFormType::class),
            'editProfileForm' => $this->createForm(EditProfileFormType::class),
            'usernameForm' => $this->createForm(UsernameFormType::class, $this->getUser()),
        ]);
    }

    #[Route('/profil/modifier/compte', name: 'app_profile_edit_submit', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function editSubmit(
        Request $request,
        AccountEditor $accountEditor,
        CsrfTokenManagerInterface $csrfTokenManager,
    ): JsonResponse {
        $form = $this->createForm(EditProfileFormType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json(['success' => false, 'message' => 'Merci de vérifier les champs saisis.'], 422);
        }

        $newEmail = $form->get('email')->getData();
        $newPlainPassword = $form->get('plainPassword')->getData();
        $currentPassword = $form->get('currentPassword')->getData();

        if ($newEmail === null && $newPlainPassword === null) {
            return $this->json(['success' => false, 'message' => 'Aucune modification à appliquer.'], 422);
        }

        try {
            $accountEditor->updateProfile($this->getUser(), $newEmail, $newPlainPassword, $currentPassword);
        } catch (BadCredentialsException $e) {
            return $this->json([
                'success' => false,
                'message' => 'Mot de passe actuel incorrect.',
                'csrfToken' => $csrfTokenManager->getToken('edit_profile_form')->getValue(),
            ], 422);
        }

        return $this->json(['success' => true, 'message' => 'Votre compte a été mis à jour.']);
    }

    #[Route('/profil/modifier/username', name: 'app_profile_edit_username', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function editUsername(Request $request, AccountEditor $accountEditor): Response
    {
        $form = $this->createForm(UsernameFormType::class, $this->getUser());
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addFlash('error', 'Nom d\'utilisateur invalide.');

            return $this->redirectToRoute('app_profile_edit');
        }

        $accountEditor->updateUsername($this->getUser(), $form->get('username')->getData());

        $this->addFlash('success', 'Nom d\'utilisateur mis à jour.');

        return $this->redirectToRoute('app_profile_edit');
    }

    #[Route('/profil/supprimer', name: 'app_profile_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(
        Request $request,
        AccountDeleter $accountDeleter,
        Security $security,
    ): Response {
        $form = $this->createForm(DeleteAccountFormType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addFlash('error', 'Veuillez confirmer votre mot de passe.');

            return $this->redirectToRoute('app_profile_edit');
        }

        $submittedPassword = $form->get('password')->getData();
        $user = $this->getUser();

        try {
            $accountDeleter->delete($user, $submittedPassword);
        } catch (BadCredentialsException $e) {
            $this->addFlash('error', 'Mot de passe incorrect.');

            return $this->redirectToRoute('app_profile_edit');
        }

        $security->logout(false);

        $this->addFlash('success', 'Votre compte a été supprimé.');

        return $this->redirectToRoute('app_login');
    }
}