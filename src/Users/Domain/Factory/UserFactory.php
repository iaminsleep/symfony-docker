<?php

declare(strict_types=1);

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;

// Все запросы о создании пользователя должны приходить через фабрику

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(string $email, string $password): User
    {
        $user = new User($email);

        $user->setPassword($password, $this->passwordHasher); // Устанавливаем пароль динамически

        return $user;
    }
}
