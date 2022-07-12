<?php

declare(strict_types=1);

namespace App\Tests\Functional\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Faker\Factory;
use Faker\Generator;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

use App\Tests\Resource\Fixture\UserFixture;

class UserRepositoryTest extends WebTestCase
{
  private UserRepository $repository;
  // private UserFactory $userFactory;
  //Faker
  private Generator $faker;
  // LiipTestFixturesBundle
  private AbstractDatabaseTool $databaseTool;

  public function setUp(): void {
    parent::setUp();
    // репозиторий и factory будут подтягиваться из контейнера
    $this->repository = static::getContainer()->get(UserRepository::class);
    // $this->userFactory = static::getContainer()->get(UserFactory::class);

    // Faker
    $this->faker = Factory::create();

    // LiipTestFixturesBundle
    $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
  }

  // Тестирование добавления пользователя в репозиторий
  public function test_user_added_successfully(): void {
    // Чтобы не брать емейл и пароль из потолка, используется библиотека faker
    $email = $this->faker->email();
    $password = $this->faker->password();

    // $user = $this->userFactory->create($email, $password);
    $user = (new UserFactory())->create($email, $password);

    // act
    $this->repository->add($user);

    // assert
    $existingUser = $this->repository->findByUlid($user->getUlid());
    $this->assertEquals($user->getUlid(), $existingUser->getUlid());
  }

  // Тестирование по наличию пользователя в БД. Предварительно можно подготовить данные для сценариев. Для этого нужно воспользоваться LiipTestFixturesBundle, чтобы можно использовать фикстуры в рамках теста.
  public function test_user_found_successfully(): void {
    // arrange
    $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
    $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE);

    // act
    $existingUser = $this->repository->findByUlid($user->getUlid());

    // assert
    $this->assertEquals($user->getUlid(), $existingUser->getUlid());
  }
}
