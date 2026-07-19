<?php

namespace App\Service;

use App\Entity\Session;
use App\Entity\User;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class QcmSessionManager
{
    private const SESSION_KEY = 'qcm_session_id';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly SessionRepository $sessionRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getOrCreateSession(User $user): Session
    {
        $httpSession = $this->requestStack->getSession();
        $sessionId = $httpSession->get(self::SESSION_KEY);

        if ($sessionId !== null) {
            $session = $this->sessionRepository->find($sessionId);

            if ($session !== null && $session->getEndedAt() === null) {
                return $session;
            }
        }

        $session = new Session();
        $session->setPlayer($user);
        $session->setStartedAt(new \DateTimeImmutable());

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        $httpSession->set(self::SESSION_KEY, $session->getId());

        return $session;
    }

    public function getCurrentQuestionNumber(Session $session): int
    {
        return count($session->getActivityLogs()) + 1;
    }
}