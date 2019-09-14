<?php
declare(strict_types=1);

namespace ElliotJReed\Exception;

use Exception;

final class InviterNameRequired extends Exception implements Form
{
    protected $message = 'An inviter name is required.';
}
