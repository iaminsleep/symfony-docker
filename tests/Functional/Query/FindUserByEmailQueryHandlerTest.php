<?php

declare(strict_types=1);

namespace App\Tests\Functional\Query;

use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Application\DTO\UserDTO;
use App\Users\Application\Query\FindUserByEmail\FindUserByEmailQuery;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FindUserByEmailQueryHandlerTest extends WebTestCase
{
    private QueryBusInterface $queryBus;
    private AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->queryBus = $this::getContainer()->get(QueryBusInterface::class); // Query bus to execute command
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get(); // LiipTestFixturesBundle
    }

    public function test_user_created_when_command_executed(): void
    {
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
