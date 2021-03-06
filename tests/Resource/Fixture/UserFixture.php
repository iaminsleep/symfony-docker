<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerTools; // Это трейт, поэтому этот инструмент можно использовать непосредственно внутри класса

    public const REFERENCE = 'user'; // Чтобы иметь возомжность получить созданного пользователя из фикстуры, необходимо создать референс. Это ссылка на созданный объект

    public function __construct(private readonly UserFactory $userFactory)
    {
    } // Добавляем инъекцию через конструктор

    public function load(ObjectManager $manager): void
    {
        $email = $this->getFaker()->email();
        $password = $this->getFaker()->password();

        $user = $this->userFactory->create($email, $password);

        $manager->persist($user); // Сохранение данных в БД
        $manager->flush(); // Функция очищает системный буфер вывода PHP, при этом всё содержимое буфера отправляется в браузер пользователя, независимо от используемого backend-а у PHP (CGI, web-сервер и т.д.)

        $this->addReference(self::REFERENCE, $user); // Добавление референса к созданному объекту
    }
}
