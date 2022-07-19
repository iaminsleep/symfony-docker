<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Service\UserPasswordHasherInterface;

class User implements AuthUserInterface
{
    private string $ulid;
    private string $email;
    private ?string $password = null; // password can be null, for example if user authenticates using social media that has no password.

    public function __construct(string $email)
    {
        $this->ulid = UlidService::generate(); // чтобы на доменном слое не было прямой зависимости с деталями реализации, вынесли генерацию ulid-ов в отдельный сервис, в модуле Shared
        $this->email = $email;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ]; // документация Symfony предлагает возвращать хотя бы одну роль пользователя
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
        // Функция занимается подчисткой чувствительных данных, в будущем есть вероятность того что кто-то сделает flush() модели, и пароль станет пустым. Поэтому этот метод лучше не трогать
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * Лучше всего хэшировать пароль в самой сущности, потому что есть вероятность что разработчик может забыть прохэшировать пароль в функции. Автоматическое динамическое хэшировать позволяет избежать этого.
     **/ 
    public function setPassword(
        ?string $password,
        UserPasswordHasherInterface $passwordHasher
    ): void {
        // Возможна установка значения пароля в null
        if (is_null($password)) {
            $this->password = null;
        }

        // В противном случае делаем хэширование пароля
        $this->password = $passwordHasher->hash($this, $password); // Передаём саму сущность и пароль
    }
}