<?php

namespace App\Service;

use App\Entity\Session;
use App\Entity\User;
use App\Repository\ActivityLogRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;

final class SessionManager
{
    private const QUESTIONS_PER_SESSION = 5;

    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly ActivityLogRepository $activityLogRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    /**
     * Crée une toute nouvelle série de QUESTIONS_PER_SESSION questions.
     */
    public function createSession(User $user): Session
    {
        $session = new Session();
        $session->setPlayer($user);
        $session->setStartedAt(new \DateTimeImmutable());

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    /**
     * Récupère une session en cours par son id, uniquement si elle appartient
     * bien au joueur et n'est pas déjà terminée. Sinon retourne null.
     */
    public function findOngoingSession(int $sessionId, User $user): ?Session
    {
        $session = $this->sessionRepository->find($sessionId);

        if ($session === null || $session->getPlayer() !== $user || $session->getEndedAt() !== null) {
            return null;
        }

        return $session;
    }

    public function getCurrentQuestionNumber(Session $session): int
    {
        return $this->activityLogRepository->countForSession($session) + 1;
    }

    /**
     * Récupère une session par son id, pour le joueur donné
     */
    public function getSessionForUser(int $sessionId, User $user): ?Session
    {
        $session = $this->sessionRepository->find($sessionId);

        if ($session === null || $session->getPlayer() !== $user) {
            return null;
        }

        return $session;
    }

    /**
     * Clôture la session si elle a atteint le nombre de questions prévu.
     * À appeler après chaque réponse enregistrée.
     */
    public function closeSessionIfComplete(Session $session): void
    {
        $answeredCount = $this->activityLogRepository->countForSession($session);

        if ($answeredCount >= self::QUESTIONS_PER_SESSION && $session->getEndedAt() === null) {
            $session->setEndedAt(new \DateTimeImmutable());
            $this->entityManager->flush();
        }
    }
}
