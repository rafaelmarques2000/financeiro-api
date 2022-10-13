<?php

namespace App\Api\V1\Utils;

enum HttpStatus: int
{
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_FOUND = 404;
    case BAD_REQUEST = 400;
    case NOT_CONTENT = 204;
    case UNAUTHORIZED = 401;
}
