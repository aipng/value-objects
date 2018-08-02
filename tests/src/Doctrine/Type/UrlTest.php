<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\Url as UrlType;
use AipNg\ValueObjects\Web\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{

	private const URL = 'http://example.org';


	public function testConvertToDatabaseValue(): void
	{
		$url = new Url(self::URL);

		$databaseValue = $this->getUrlDatabaseType()->convertToDatabaseValue($url, $this->createTestPlatform());

		$this->assertSame($url->getValue(), $databaseValue);
	}


	public function testConvertNullToDatabaseValue(): void
	{
		$this->assertNull($this->getUrlDatabaseType()->convertToDatabaseValue(null, $this->createTestPlatform()));
	}


	public function testConvertNullToPHPValue(): void
	{
		$phpValue = $this->getUrlDatabaseType()->convertToPHPValue(null, $this->createTestPlatform());

		$this->assertNull($phpValue);
	}


	public function testConvertUrlToPHPValue(): void
	{
		$textUrl = self::URL;

		$urlObject = $this->getUrlDatabaseType()->convertToPHPValue($textUrl, $this->createTestPlatform());

		$this->assertInstanceOf(Url::class, $urlObject);
		$this->assertSame($textUrl, $urlObject->getValue());
	}


	public function testConvertInstanceToPHPValue(): void
	{
		$url = new Url(self::URL);

		$urlObject = $this->getUrlDatabaseType()->convertToPHPValue($url, $this->createTestPlatform());

		$this->assertSame($url, $urlObject);
	}


	private function getUrlDatabaseType(): Type
	{
		if (!UrlType::hasType('url')) {
			UrlType::addType('url', UrlType::class);
		}

		return UrlType::getType('url');
	}


	private function createTestPlatform(): AbstractPlatform
	{
		/** @var \Doctrine\DBAL\Platforms\AbstractPlatform $mock */
		$mock = \Mockery::mock(AbstractPlatform::class);

		return $mock;
	}

}
