<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class User 
{
  private string $ulid;
  private string $email;
  private string $password;

  public function __construct(string $email, string $password) {
    $this->ulid = UlidService::generate(); // чтобы на доменном слое не было прямой зависимости с деталями реализации, вынесли генерацию ulid-ов в отдельный сервис, в модуле Shared.
    $this->email = $email;
    $this->password = $password;
  }

  /**
   * Get the value of ulid
   */ 
  public function getUlid() : string
  {
    return $this->ulid;
  }

  /**
   * Get the value of email
   */ 
  public function getEmail() : string
  {
    return $this->email;
  }

  /**
   * Get the value of password
   */ 
  public function getPassword() : string
  {
    return $this->password;
  }
}