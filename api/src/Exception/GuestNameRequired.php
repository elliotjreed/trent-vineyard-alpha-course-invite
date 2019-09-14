<?php
declare(strict_types=1);

namespace ElliotJReed\Exception;

use Exception;

final class GuestNameRequired extends Exception implements Form
{
    protected $message = 'A guest name is required.';
}
