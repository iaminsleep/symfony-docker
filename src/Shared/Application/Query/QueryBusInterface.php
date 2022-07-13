<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

use App\Shared\Application\Query\QueryInterface;

// Интерфейс шины запросов

interface QueryBusInterface {
  public function execute(QueryInterface $query): mixed; // Возвращается DTO-модель
}