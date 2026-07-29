<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

final class AccountEditor
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    /**
     * Update email et/ou mot de passe si input rempli
     * Check MDP actuel si un des 2 inputs remplis
     * Changement  username seul passe par updateUsername()
     *
     * @throws BadCredentialsException si le mot de passe actuel ne correspond pas
     */
    public function updateProfile(User $user, ?string $newEmail, ?string $newPlainPassword, string $currentPassword): void
    {
        if ($newEmail === null && $newPlainPassword === null) {
            return;
        }

        if (!$this->userPasswordHasher->isPasswordValid($user, $currentPassword)) {
            throw new BadCredentialsException('Mot de passe actuel incorrect.');
        }

        if ($newEmail !== null) {
            $user->setEmail($newEmail);
        }

        if ($newPlainPassword !== null) {
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $newPlainPassword));
        }

        $this->entityManager->flush();
    }

    /**
     * Update Username only
     */
    public function updateUsername(User $user, string $newUsername): void
    {
        $user->setUsername($newUsername);
        $this->entityManager->flush();
    }
}