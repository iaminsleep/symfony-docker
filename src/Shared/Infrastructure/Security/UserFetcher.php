<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Security\UserFetcherInterface;

use Symfony\Component\Security\Core\Security;
use Webmozart\Assert\Assert;

// Реализация сервиса на инфраструктурном уровне
// Механизм получения пользователя

class UserFetcher implements UserFetcherInterface
{
  public function __construct(private readonly Security $security) {}

  public function getAuthUser(): AuthUserInterface {
    /** @var AuthUserInterface $user */
    $user = $this->security->getUser(); // с помощью хелпера Security получаем информацию о текущем авторизованном пользователе

    Assert::notNull($user, 'Current user not found, check security access list!'); // проверяем утверждение, что пользователь действительно существует
    Assert::isInstanceOf($user, AuthUserInterface::class, sprintf('Invalid user type %s', \get_class($user))); // и что он наследуется от верного интерфейса

    return $user; // в положительном сцерании возвращаем инстанс авторизованного пользователя
  }
}