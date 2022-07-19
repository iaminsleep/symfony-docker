<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shared\Domain\Security\UserFetcherInterface;

#[Route('/api/users/me', methods: ['GET'])]

class GetMeAction
{
  public function __construct(private readonly UserFetcherInterface $userFetcher) {}

  public function __invoke() {
    $user = $this->userFetcher->getAuthUser(); // извлекаем текущего авторизованного пользователя

    return new JsonResponse([
      'ulid' => $user->getUlid(),
      'email' => $user->getEmail(),
    ]);
  }
}