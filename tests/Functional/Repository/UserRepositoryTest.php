<?php

namespace App\Tests\Functional\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Users\Infrastructure\Repository\UserRepository;
use App\Users\Domain\Factory\UserFactory;

use Faker\Factory;
use Faker\Generator;

class UserRepositoryTest extends WebTestCase
{
  private UserRepository $repository;
  private Generator $faker;

  public function setUp(): void {
    parent::setUp();
    // репозиторий будет подтягиваться из контейнера
    $this->repository = static::getContainer()->get(UserRepository::class);

    $this->faker = Factory::create();
  }

  // Тестирование добавления пользователя в репозиторий
  public function test_user_added_successfully(): void {
    // Чтобы не брать емейл и пароль из потолка, используется библиотека faker
    $email = $this->faker->email();
    $password = $this->faker->password();

    $user = (new UserFactory())->create($email, $password);

    // act
    $this->repository->add($user);

    // assert
    $existingUser = $this->repository->findByUlid($user->getUlid());
    $this->assertEquals($user->getUlid(), $existingUser->getUlid());
  }
}
