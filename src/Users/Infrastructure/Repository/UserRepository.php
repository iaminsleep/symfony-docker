<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Repository;

use App\Users\Domain\Repository\UserRepositoryInterface;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Users\Domain\Entity\User;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, User::class);
  }

  public function add(User $user): void
  {
    $this->_em->persist($user);
    $this->_em->flush();
  }

  public function findByUlid(string $ulid): User
  {
    return $this->find($ulid);
  }

  public function findByEmail(string $email): ?User // User may not be found, that's why null can be returned
  {
    return $this->findOneBy(['email' => $email]);
  }
}