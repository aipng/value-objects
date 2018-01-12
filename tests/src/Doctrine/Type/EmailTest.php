<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\Email as EmailType;
use AipNg\ValueObjects\Web\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{

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


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->emailDatabaseType->convertToPHPValue(null, $this->platform);

		$this->assertSame(null, $phpValue);
	}


	public function testConvertEmailToPHPValue(): void
	{
		$textEmail = 'test@example.org';

		$emailObject = $this->emailDatabaseType->convertToPHPValue($textEmail, $this->platform);

		$this->assertInstanceOf(Email::class, $emailObject);
		$this->assertSame($textEmail, $emailObject->getValue());
	}

}
