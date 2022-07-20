<?php

/* Data Transfer Object (DTO) — один из шаблонов проектирования, используется для передачи данных между подсистемами приложения. Data Transfer Object, в отличие от business object или data access object не должен содержать какого-либо поведения. */

/* DTO — это так называемый value-object на стороне сервера, который хранит данные, используемые в слое представления. */

/* Таким образом, данная модель предназначена только для хранения и переноса данных. */

declare(strict_types=1);

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;

class UserDTO
{
    public function __construct(public readonly string $ulid, public readonly string $email)
    {
    }

    public static function fromEntityToDTO(User $user): self
    {
        // Функция для создания DTO из Entity
        return new self($user->getUlid(), $user->getEmail()); // используем геттеры
    }
}
