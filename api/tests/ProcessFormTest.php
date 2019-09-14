<?php
declare(strict_types=1);

namespace ElliotJReed\Tests;

use ElliotJReed\Exception\FirstLineOfAddressRequired;
use ElliotJReed\Exception\GuestNameRequired;
use ElliotJReed\Exception\InviterNameRequired;
use ElliotJReed\Exception\PostcodeRequired;
use ElliotJReed\Exception\TownRequired;
use ElliotJReed\ProcessForm;
use PDO;
use PHPUnit\Framework\TestCase;

final class ProcessFormTest extends TestCase
{
    private $pdo;

    public function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:', '', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $this->pdo->exec("
            CREATE TABLE invitations (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                guest_name VARCHAR(191) NOT NULL,
                inviter_name VARCHAR(191) NOT NULL,
                address_one VARCHAR(191) NOT NULL,
                address_two VARCHAR(191) NOT NULL DEFAULT '',
                town VARCHAR(191) NOT NULL,
                county VARCHAR(191) NOT NULL DEFAULT '',
                postcode VARCHAR(11) NOT NULL,
                user_agent VARCHAR(191) NULL
            )
        ");
    }

    public function testItInsertsFormDataIntoDatabase(): void
    {
        $process = (new ProcessForm($this->pdo))->process([
            'guest_name' => 'Mrs Guest',
            'inviter_name' => 'Mr Inviter',
            'address_one' => '1 Invite Lane',
            'address_two' => 'Invitation Gardens',
            'town' => 'Inviteville',
            'county' => 'Inviteshire',
            'postcode' => 'IN1 1VI'
        ]);

        $query = $this->pdo->query('SELECT * FROM invitations')->fetch();

        $this->assertSame('Mrs Guest', $query['guest_name']);
        $this->assertSame('Mr Inviter', $query['inviter_name']);
        $this->assertSame('1 Invite Lane', $query['address_one']);
        $this->assertSame('Invitation Gardens', $query['address_two']);
        $this->assertSame('Inviteville', $query['town']);
        $this->assertSame('Inviteshire', $query['county']);
        $this->assertSame('IN1 1VI', $query['postcode']);
        $this->assertNull($query['user_agent']);
        $this->assertTrue($process);
    }

    public function testItInsertsFormDataIntoDatabaseAllowingEmptySecondLineOfAddressAndCounty(): void
    {
        $process = (new ProcessForm($this->pdo))->process([
            'guest_name' => 'Mrs Guest',
            'inviter_name' => 'Mr Inviter',
            'address_one' => '1 Invite Lane',
            'address_two' => '',
            'town' => 'Inviteville',
            'county' => '',
            'postcode' => 'IN1 1VI'
        ]);

        $query = $this->pdo->query('SELECT * FROM invitations')->fetch();

        $this->assertSame('Mrs Guest', $query['guest_name']);
        $this->assertSame('Mr Inviter', $query['inviter_name']);
        $this->assertSame('1 Invite Lane', $query['address_one']);
        $this->assertSame('', $query['address_two']);
        $this->assertSame('Inviteville', $query['town']);
        $this->assertSame('', $query['county']);
        $this->assertSame('IN1 1VI', $query['postcode']);
        $this->assertNull($query['user_agent']);
        $this->assertTrue($process);
    }

    public function testItThrowsExceptionOnEmptyGuestName(): void
    {
        $this->expectException(GuestNameRequired::class);

        (new ProcessForm($this->pdo))->process([
            'guest_name' => '',
            'inviter_name' => 'Mr Inviter',
            'address_one' => '1 Invite Lane',
            'address_two' => 'Invitation Gardens',
            'town' => 'Inviteville',
            'county' => 'Inviteshire',
            'postcode' => 'IN1 1VI'
        ]);
    }

    public function testItThrowsExceptionOnEmptyInviterName(): void
    {
        $this->expectException(InviterNameRequired::class);

        (new ProcessForm($this->pdo))->process([
            'guest_name' => 'Mrs Guest',
            'inviter_name' => '',
            'address_one' => '1 Invite Lane',
            'address_two' => 'Invitation Gardens',
            'town' => 'Inviteville',
            'county' => 'Inviteshire',
            'postcode' => 'IN1 1VI'
        ]);
    }

    public function testItThrowsExceptionOnEmptyFirstLineOfAddress(): void
    {
        $this->expectException(FirstLineOfAddressRequired::class);

        (new ProcessForm($this->pdo))->process([
            'guest_name' => 'Mrs Guest',
            'inviter_name' => 'Mr Inviter',
            'address_one' => '',
            'address_two' => 'Invitation Gardens',
            'town' => 'Inviteville',
            'county' => 'Inviteshire',
            'postcode' => 'IN1 1VI'
        ]);
    }

    public function testItThrowsExceptionOnEmptyTown(): void
    {
        $this->expectException(TownRequired::class);

        (new ProcessForm($this->pdo))->process([
            'guest_name' => 'Mrs Guest',
            'inviter_name' => 'Mr Inviter',
            'address_one' => '1 Invite Lane',
            'address_two' => 'Invitation Gardens',
            'town' => '',
            'county' => 'Inviteshire',
            'postcode' => 'IN1 1VI'
        ]);
    }

    public function testItThrowsExceptionOnEmptyPostcode(): void
    {
        $this->expectException(PostcodeRequired::class);

        (new ProcessForm($this->pdo))->process([
            'guest_name' => 'Mrs Guest',
            'inviter_name' => 'Mr Inviter',
            'address_one' => '1 Invite Lane',
            'address_two' => 'Invitation Gardens',
            'town' => 'Inviteville',
            'county' => 'Inviteshire',
            'postcode' => ''
        ]);
    }
}
