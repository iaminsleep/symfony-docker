<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

use App\Shared\Application\Command\CommandInterface;

// Интерфейс командной шины

interface CommandBusInterface {
  public function execute(CommandInterface $command): mixed; // Возвращается некий результат
}