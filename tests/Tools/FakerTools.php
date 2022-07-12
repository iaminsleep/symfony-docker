<?php

declare(strict_types=1);

namespace App\Tests\Tools;

use Faker\Factory;
use Faker\Generator;

trait FakerTools // Трейты можно подключать в любом классе
{
  public function getFaker(): Generator {
    return Factory::create();
  }
}