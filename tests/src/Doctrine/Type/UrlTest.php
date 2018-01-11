<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\Url as UrlType;
use AipNg\ValueObjects\Web\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{

	/** @var \Mockery\MockInterface|\Doctrine\DBAL\Platforms\AbstractPlatform */
	private $platform;

	/** @var \AipNg\ValueObjects\Doctrine\Type\Url */
	private $urlDatabaseType;


	protected function setUp(): void
	{
		parent::setUp();
		$this->platform = \Mockery::mock(AbstractPlatform::class);

		if (!UrlType::hasType('url')) {
			UrlType::addType('url', UrlType::class);
		}

		$this->urlDatabaseType = UrlType::getType('url');
	}


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->urlDatabaseType->convertToPHPValue(null, $this->platform);

		$this->assertSame(null, $phpValue);
	}


	public function testConvertUrlToPHPValue(): void
	{
		$textUrl = 'http://www.example.org';

		$urlObject = $this->urlDatabaseType->convertToPHPValue($textUrl, $this->platform);

		$this->assertInstanceOf(Url::class, $urlObject);
		$this->assertSame($textUrl, $urlObject->getValue());
	}

}
