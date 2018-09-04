<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Web;

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
	 * @dataProvider getNormalizeUrlData
	 */
	public function testNormalizeUrl(string $url): void
	{
		$this->assertSame(self::URL, (new Url($url))->getValue());
	}


	/**
	 * @return mixed[]
	 */
	public function getNormalizeUrlData(): array
	{
		return [
			['  ' . self::URL . '  '],
			["\t" . self::URL . "\r\n\n"],
		];
	}


	public function testUrlIsCaseSensitive(): void
	{
		$url = 'http://aip.cz/This-is-OK/';

		$this->assertTrue((new Url($url))->equalsValue($url));
	}


	public function testThrowExceptionOnInvalidUrl(): void
	{
		$this->expectException(InvalidArgumentException::class);

		new Url('');
	}

}
