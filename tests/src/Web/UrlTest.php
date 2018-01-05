<?php

declare(strict_types = 1);

namespace AipNg\Tests\ValueObjects\Web;

use AipNg\ValueObjects\InvalidArgumentException;
use AipNg\ValueObjects\Web\Url;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{

	private const URL = 'http://www.example.org';


	public function testCreation(): void
	{
		$url = new Url(self::URL);

		$this->assertSame(self::URL, $url->getValue());
	}


	public function testToString(): void
	{
		$url = new Url(self::URL);

		$this->assertSame(self::URL, (string) $url);
	}


	/**
	 * @dataProvider getNormalizeUrlTestData
	 */
	public function testNormalizeUrl(string $url): void
	{
		$this->assertSame(self::URL, (new Url($url))->getValue());
	}


	public function testThrowExceptionOnInvalidUrl(): void
	{
		$this->expectException(InvalidArgumentException::class);

		new Url('');
	}


	/**
	 * @return string[]
	 */
	public function getNormalizeUrlTestData(): array
	{
		return [
			['  ' . self::URL . '  '],
			["\t" . self::URL . "\r\n\n"],
			[strtoupper(self::URL)],
		];
	}

}
