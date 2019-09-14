<?php
declare(strict_types=1);

namespace ElliotJReed\Exception;

use Exception;

final class FirstLineOfAddressRequired extends Exception implements Form
{
    protected $message = 'The first line of the address is required.';
}
