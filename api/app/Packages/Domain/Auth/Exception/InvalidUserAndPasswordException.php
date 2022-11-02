<?php

namespace App\Packages\Domain\Auth\Exception;

use App\Packages\Domain\General\Exceptions\AuthFailedException;

class InvalidUserAndPasswordException extends AuthFailedException
{
}
