<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\EmailType;
use AipNg\ValueObjects\Web\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

final class EmailTypeTest extends TestCase
{

	private const EMAIL = 'test@example.org';


	public function testConvertToDatabaseValue(): void
	{
		$email = new Email(self::EMAIL);

		$databaseValue = $this->getEmailDatabaseType()->convertToDatabaseValue($email, $this->createTestPlatform());

		$this->assertSame($email->getValue(), $databaseValue);
	}


	public function testConvertNullToDatabaseValue(): void
	{
		$this->assertNull($this->getEmailDatabaseType()->convertToDatabaseValue(null, $this->createTestPlatform()));
	}


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->getEmailDatabaseType()->convertToPHPValue(null, $this->createTestPlatform());

		$this->assertNull($phpValue);
	}


	public function testConvertEmailToPHPValue(): void
	{
		$textEmail = self::EMAIL;

		$emailObject = $this->getEmailDatabaseType()->convertToPHPValue($textEmail, $this->createTestPlatform());

		$this->assertInstanceOf(Email::class, $emailObject);
		$this->assertSame($textEmail, $emailObject->getValue());
	}


	public function testConvertInstanceToPHPValue(): void
	{
		$email = new Email(self::EMAIL);

		$emailObject = $this->getEmailDatabaseType()->convertToPHPValue($email, $this->createTestPlatform());

		$this->assertSame($email, $emailObject);
	}


	private function getEmailDatabaseType(): Type
	{
		if (!EmailType::hasType('email')) {
			EmailType::addType('email', EmailType::class);
		}

		return EmailType::getType('email');
	}


	private function createTestPlatform(): AbstractPlatform
	{
		/** @var \Doctrine\DBAL\Platforms\AbstractPlatform $mock */
		$mock = \Mockery::mock(AbstractPlatform::class);

		return $mock;
	}

}
