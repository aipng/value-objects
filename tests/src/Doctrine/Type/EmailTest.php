<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\Email as EmailType;
use AipNg\ValueObjects\Web\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{

	private const EMAIL = 'test@example.org';

	/** @var \Mockery\MockInterface|\Doctrine\DBAL\Platforms\AbstractPlatform */
	private $platform;

	/** @var \AipNg\ValueObjects\Doctrine\Type\Email */
	private $emailDatabaseType;


	protected function setUp(): void
	{
		parent::setUp();
		$this->platform = \Mockery::mock(AbstractPlatform::class);

		if (!EmailType::hasType('email')) {
			EmailType::addType('email', EmailType::class);
		}

		$this->emailDatabaseType = EmailType::getType('email');
	}


	public function testConvertToDatabaseValue(): void
	{
		$email = new Email(self::EMAIL);

		$databaseValue = $this->emailDatabaseType->convertToDatabaseValue($email, $this->platform);

		$this->assertSame($email->getValue(), $databaseValue);
	}


	public function testConvertNullToDatabaseValue(): void
	{
		$this->assertNull($this->emailDatabaseType->convertToDatabaseValue(null, $this->platform));
	}


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->emailDatabaseType->convertToPHPValue(null, $this->platform);

		$this->assertSame(null, $phpValue);
	}


	public function testConvertEmailToPHPValue(): void
	{
		$textEmail = self::EMAIL;

		$emailObject = $this->emailDatabaseType->convertToPHPValue($textEmail, $this->platform);

		$this->assertInstanceOf(Email::class, $emailObject);
		$this->assertSame($textEmail, $emailObject->getValue());
	}


	public function testConvertInstanceToPHPValue(): void
	{
		$email = new Email(self::EMAIL);

		$emailObject = $this->emailDatabaseType->convertToPHPValue($email, $this->platform);

		$this->assertSame($email, $emailObject);
	}

}
