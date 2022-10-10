<?php

namespace App\Packages\Domain\User\Service;

use Illuminate\Support\Collection;

interface UserServiceInterface
{
     public function list(): Collection;
}
