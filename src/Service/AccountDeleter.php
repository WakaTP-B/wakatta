<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


final class AccountDeleter
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    /**
     * Verifie le mot de passe puis supprime definitivement le compte (RGPD).
     * Cascade en BDD (onDelete: 'CASCADE') efface ActivityLog, Session, XpTransaction.
     *
     * @throws BadCredentialsException si le mot de passe soumis ne correspond pas
     */
    public function delete(User $user, string $submittedPassword): void
    {
        if (!$this->userPasswordHasher->isPasswordValid($user, $submittedPassword)) {
            throw new BadCredentialsException('Mot de passe incorrect.');
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}