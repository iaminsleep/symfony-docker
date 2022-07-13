<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Command\CommandBusInterface;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

// Реализация командной шины

class CommandBus implements CommandBusInterface {
  use HandleTrait;

  public function __construct(MessageBusInterface $commandBus) {
    $this->messageBus = $commandBus;
  }

  public function execute(CommandInterface $command): mixed {
    return $this->handle($command); // Возвращается некий результат
  }
}