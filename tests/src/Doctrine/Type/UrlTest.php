<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\Url as UrlType;
use AipNg\ValueObjects\Web\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{

	private const URL = 'http://example.org';

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


	public function testConvertToDatabaseValue(): void
	{
		$url = new Url(self::URL);

		$databaseValue = $this->urlDatabaseType->convertToDatabaseValue($url, $this->platform);

		$this->assertSame($url->getValue(), $databaseValue);
	}


	public function testConvertNullToDatabaseValue(): void
	{
		$this->assertNull($this->urlDatabaseType->convertToDatabaseValue(null, $this->platform));
	}


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->urlDatabaseType->convertToPHPValue(null, $this->platform);

		$this->assertSame(null, $phpValue);
	}


	public function testConvertUrlToPHPValue(): void
	{
		$textUrl = self::URL;

		$urlObject = $this->urlDatabaseType->convertToPHPValue($textUrl, $this->platform);

		$this->assertInstanceOf(Url::class, $urlObject);
		$this->assertSame($textUrl, $urlObject->getValue());
	}


	public function testConvertInstanceToPHPValue(): void
	{
		$url = new Url(self::URL);

		$urlObject = $this->urlDatabaseType->convertToPHPValue($url, $this->platform);

		$this->assertSame($url, $urlObject);
	}

}
