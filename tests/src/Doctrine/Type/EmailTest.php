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
	private $urlDatabaseType;


	protected function setUp(): void
	{
		parent::setUp();
		$this->platform = \Mockery::mock(AbstractPlatform::class);

		if (!EmailType::hasType('email')) {
			EmailType::addType('email', EmailType::class);
		}

		$this->urlDatabaseType = EmailType::getType('email');
	}


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->urlDatabaseType->convertToPHPValue(null, $this->platform);

		$this->assertSame(null, $phpValue);
	}


	public function testConvertEmailToPHPValue(): void
	{
		$textUrl = 'test@example.org';

		$emailObject = $this->urlDatabaseType->convertToPHPValue($textUrl, $this->platform);

		$this->assertInstanceOf(Email::class, $emailObject);
		$this->assertSame($textUrl, $emailObject->getValue());
	}

}
