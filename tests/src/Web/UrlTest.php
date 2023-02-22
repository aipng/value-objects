<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Web;

use AipNg\ValueObjects\InvalidArgumentException;
use AipNg\ValueObjects\Web\Url;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{

	public function testCreation(): void
	{
		$url = Url::from('https://www.example.org');

		$this->assertSame('https://www.example.org', $url->getValue());
	}


	public function testToString(): void
	{
		$url = Url::from('https://www.example.org');

		$this->assertSame('https://www.example.org', (string) $url);
	}


	#[DataProvider('getNormalizeUrlData')]
	public function testNormalizeUrl(string $url): void
	{
		$this->assertSame('https://www.example.org', Url::from($url)->getValue());
	}


	/**
	 * @return array<array<int, string>>
	 */
	public static function getNormalizeUrlData(): array
	{
		return [
			['  https://www.example.org  '],
			["\thttps://www.example.org\r\n\n"],
		];
	}


	public function testUrlIsCaseSensitive(): void
	{
		$url = 'https://aip.cz/This-is-OK/';

		$this->assertTrue(Url::from($url)->equalsValue($url));
	}


	public function testThrowExceptionOnInvalidUrl(): void
	{
		$this->expectException(InvalidArgumentException::class);

		Url::from('');
	}

}
