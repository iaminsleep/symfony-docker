<?php

declare(strict_types=1);

namespace App\Tests\Functional\Query;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Faker\Factory;
use App\Shared\Infrastructure\Bus\QueryBus;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Application\Query\FindUserByEmail\FindUserByEmailQuery;
use App\Users\Application\DTO\UserDTO;

class FindUserByEmailQueryHandlerTest extends WebTestCase
{
  public function setUp(): void {
    parent::setUp();

    $this->faker = Factory::create(); //Faker

    $this->queryBus = $this::getContainer()->get(QueryBus::class); // Шина для запросов

    $this->userRepository = $this::getContainer()->get(UserRepositoryInterface::class); // Класс для работы с пользователями

    $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get(); // LiipTestFixturesBundl
  }

  public function test_user_created_when_command_executed() : void {
    // arrange
    $referenceRepository = $this->databaseTool->loadFixtures([UserFixture::class])->getReferenceRepository(); // воспользуемся фикстурой для заполнения данных в базе данных

    /** @var User $user */
    $user = $referenceRepository->getReference(UserFixture::REFERENCE);

    $query = new FindUserByEmailQuery($user->getEmail()); // подготавливаем запрос для поиска пользователя по емейлу

    // act
    $userDTO = $this->queryBus->execute($query); // выполняем запрос через шину запросов

    // assert
    $this->assertInstanceOf(UserDTO::class, $userDTO); // проверяем утверждение, является ли полученный результат объектом передачи данных (если пользователь не найден, то false)
  }
}
