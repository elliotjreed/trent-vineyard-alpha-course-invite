<?php
declare(strict_types=1);

namespace ElliotJReed;

use ElliotJReed\Exception\FirstLineOfAddressRequired;
use ElliotJReed\Exception\GuestNameRequired;
use ElliotJReed\Exception\InviterNameRequired;
use ElliotJReed\Exception\PostcodeRequired;
use ElliotJReed\Exception\TownRequired;
use PDO;

final class ProcessForm
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function process(array $formData): bool
    {
        $this->ensureRequiredDataIsPresent($formData);

        $query = $this->pdo->prepare('INSERT INTO invitations
          (guest_name, inviter_name, address_one, address_two, town, county, postcode, user_agent)
          VALUES (:guest_name, :inviter_name, :address_one, :address_two, :town, :county, :postcode, :user_agent)
        ');

        return $query->execute([
            'guest_name' => $formData['guest_name'],
            'inviter_name' => $formData['inviter_name'],
            'address_one' => $formData['address_one'],
            'address_two' => $formData['address_two'] ?? '',
            'town' => $formData['town'],
            'county' => $formData['county'] ?? '',
            'postcode' => $formData['postcode'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    }

    private function ensureRequiredDataIsPresent(array $formData): void
    {
        if (empty($formData['guest_name'])) {
            throw new GuestNameRequired();
        }

        if (empty($formData['inviter_name'])) {
            throw new InviterNameRequired();
        }

        if (empty($formData['address_one'])) {
            throw new FirstLineOfAddressRequired();
        }

        if (empty($formData['town'])) {
            throw new TownRequired();
        }

        if (empty($formData['postcode'])) {
            throw new PostcodeRequired();
        }
    }
}
