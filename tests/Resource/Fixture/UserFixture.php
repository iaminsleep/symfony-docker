<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use Doctrine\Persistence\ObjectManager;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixture extends Fixture
{
  use FakerTools; // Это трейт, поэтому этот инструмент можно использовать непосредственно внутри класса

  const REFERENCE = 'user'; // Чтобы иметь возомжность получить созданного пользователя из фикстуры, необходимо создать референс. Это ссылка на созданный объект

  public function load(ObjectManager $manager) {
    $email = $this->getFaker()->email();
    $password = $this->getFaker()->password();

    $user = (new UserFactory())->create($email, $password);

    $manager->persist($user); // Сохранение данных в БД
    $manager->flush(); // Функция очищает системный буфер вывода PHP, при этом всё содержимое буфера отправляется в браузер пользователя, независимо от используемого backend-а у PHP (CGI, web-сервер и т.д.)

    $this->addReference(self::REFERENCE, $user); // Добавление референса к созданному объекту
  }
}