<?php

declare(strict_types=1);

namespace App\Shared\Domain\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Интерфейс авторизированного пользователя

interface AuthUserInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function getUlid(): string;

    public function getEmail(): string;
}
