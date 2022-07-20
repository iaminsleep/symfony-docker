<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

class FindUserByEmailQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(FindUserByEmailQuery $query): UserDTO
    { // DTO должны храниться на прикладном слое, поэтому папка DTO находится вместе с Command и Query в прикладном слое (Application)
        $user = $this->userRepository->findByEmail($query->email);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return UserDTO::fromEntityToDTO($user);
    }
}
