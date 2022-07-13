<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Application\Query\QueryBusInterface;

// Реализация командной шины

class QueryBus implements QueryBusInterface {
  use HandleTrait;

  public function __construct(MessageBusInterface $queryBus) {
    $this->messageBus = $queryBus;
  }

  public function execute(QueryInterface $query): mixed {
    return $this->handle($query); // Возвращается DTO-объект
  }
} // Подготовка структуры для реализации подхода CQRS завершена