<?php
declare(strict_types=1);

namespace ElliotJReed\Exception;

use Exception;

final class TownRequired extends Exception implements Form
{
    protected $message = 'The town or city is required.';
}
