<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Doctrine\Type;

use AipNg\ValueObjects\Doctrine\Type\UrlType;
use AipNg\ValueObjects\Web\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

final class UrlTypeTest extends TestCase
{

	/** @var \Doctrine\DBAL\Platforms\AbstractPlatform&\PHPUnit\Framework\MockObject\MockObject */
	private AbstractPlatform $platform;


	protected function setUp(): void
	{
		$this->platform = $this->getMockBuilder(AbstractPlatform::class)->getMock();
	}


	public function testShouldConvertToDatabaseValue(): void
	{
		$url = new Url('https://example.org');

		$databaseValue = $this->getUrlDatabaseType()->convertToDatabaseValue($url, $this->platform);

		$this->assertSame($url->getValue(), $databaseValue);
	}


	public function testShouldConvertNullToDatabaseValue(): void
	{
		$this->assertNull($this->getUrlDatabaseType()->convertToDatabaseValue(null, $this->platform));
	}


	public function testShouldConvertNullToPHPValue(): void
	{
		$phpValue = $this->getUrlDatabaseType()->convertToPHPValue(null, $this->platform);

		$this->assertNull($phpValue);
	}


	public function testShouldConvertUrlToPHPValue(): void
	{
		$textUrl = 'https://example.org';

		$urlObject = $this->getUrlDatabaseType()->convertToPHPValue($textUrl, $this->platform);

		$this->assertInstanceOf(Url::class, $urlObject);
		$this->assertSame($textUrl, $urlObject->getValue());
	}


	public function testShouldConvertInstanceToPHPValue(): void
	{
		$url = new Url('https://example.org');

		$urlObject = $this->getUrlDatabaseType()->convertToPHPValue($url, $this->platform);

		$this->assertSame($url, $urlObject);
	}


	private function getUrlDatabaseType(): Type
	{
		if (!UrlType::hasType('url')) {
			UrlType::addType('url', UrlType::class);
		}

		return UrlType::getType('url');
	}

}
