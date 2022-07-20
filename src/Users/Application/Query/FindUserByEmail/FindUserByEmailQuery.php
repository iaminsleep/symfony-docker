<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryInterface;

class FindUserByEmailQuery implements QueryInterface
{
    public function __construct(public readonly string $email)
    {
    } // Чтобы повысить безопасность приложения, создаётся отдельный класс где в конструкторе пермененной $email даётся уточнение типа данных а также свойство readonly. Таким образом, данную переменную нельзя изменить и её можно только прочитать, т.к она уже задана свойствами.
}
