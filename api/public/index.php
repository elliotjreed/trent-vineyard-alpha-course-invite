<?php
declare(strict_types=1);

use ElliotJReed\Exception\Form;
use ElliotJReed\ProcessForm;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    \header("Location: about:blank");
    exit();
}

\header('Content-Type: application/json');

require __DIR__ . '/../vendor/autoload.php';

$db = new \PDO('sqlite:' . __DIR__ . '/../invitations.sqlite3', '', '', [
  \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
]);

try {
    echo \json_encode((new ProcessForm($db))->process($_POST));
} catch (Form $exception) {
    echo \json_encode($exception->getMessage());
}
