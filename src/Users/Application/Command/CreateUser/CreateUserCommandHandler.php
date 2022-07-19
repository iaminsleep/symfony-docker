<?php

declare(strict_types=1);

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;

use App\Users\Application\Command\CreateUser\CreateUserCommand;

use App\Users\Domain\Factory\UserFactory;

class CreateUserCommandHandler implements CommandHandlerInterface 
{
  public function __construct(private readonly UserRepositoryInterface $userRepository, private readonly UserFactory $userFactory) {}

  /**
   * @return string Возвращает ID созданного пользователя
   */
  public function __invoke(CreateUserCommand $createUserCommand) : string {
    $user = $this->userFactory->create($createUserCommand->email, $createUserCommand->password);
    $this->userRepository->add($user);

    return $user->getUlid(); // return user ID
  }
}