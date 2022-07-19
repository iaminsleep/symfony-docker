<?php

declare(strict_types=1);

namespace App\Shared\Domain\Security;

use App\Shared\Domain\Security\AuthUserInterface;

interface UserFetcherInterface
{
  public function getAuthUser(): AuthUserInterface; // returns AuthUserInterface
}