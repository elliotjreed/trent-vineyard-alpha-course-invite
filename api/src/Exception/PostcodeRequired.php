<?php
declare(strict_types=1);

namespace ElliotJReed\Exception;

use Exception;

final class PostcodeRequired extends Exception implements Form
{
    protected $message = 'The postcode is required.';
}
