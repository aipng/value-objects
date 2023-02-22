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

	/** @var \Doctrine\DBAL\Platforms\AbstractPlatform&\PHPUnit\Framework\MockObject\MockObject */
	private AbstractPlatform $platform;


	protected function setUp(): void
	{
		$this->platform = $this->getMockBuilder(AbstractPlatform::class)->getMock();
	}


	public function testShouldConvertEmailToDatabaseValue(): void
	{
		$email = new Email('test@example.org');

		$databaseValue = $this->getEmailDatabaseType()->convertToDatabaseValue($email, $this->platform);

		$this->assertSame($email->getValue(), $databaseValue);
	}


	public function testShouldConvertNullToDatabaseValue(): void
	{
		$this->assertNull($this->getEmailDatabaseType()->convertToDatabaseValue(null, $this->platform));
	}


	public function testShouldConvertNullToPHPValue(): void
	{
		$phpValue = $this->getEmailDatabaseType()->convertToPHPValue(null, $this->platform);

		$this->assertNull($phpValue);
	}


	public function testShouldConvertEmailToPHPValue(): void
	{
		$textEmail = 'test@example.org';

		$emailObject = $this->getEmailDatabaseType()->convertToPHPValue($textEmail, $this->platform);

		$this->assertInstanceOf(Email::class, $emailObject);
		$this->assertSame($textEmail, $emailObject->getValue());
	}


	public function testShouldConvertInstanceToPHPValue(): void
	{
		$email = new Email('test@example.org');

		$emailObject = $this->getEmailDatabaseType()->convertToPHPValue($email, $this->platform);

		$this->assertSame($email, $emailObject);
	}


	private function getEmailDatabaseType(): Type
	{
		if (!EmailType::hasType('email')) {
			EmailType::addType('email', EmailType::class);
		}

		return EmailType::getType('email');
	}

}
