<?php

declare(strict_types = 1);

namespace AipNg\Tests\ValueObjects\Web;

require __DIR__ . '/../../bootstrap.php';

use AipNg\ValueObjects\Web\Url;
use Tester\Assert;
use Tester\TestCase;

final class UrlTest extends TestCase
{

	private const URL = 'http://www.example.org';


	public function testCreation(): void
	{
		$url = new Url(self::URL);

		Assert::same(self::URL, $url->getValue());
	}


	public function testToString(): void
	{
		$url = new Url(self::URL);

		Assert::same(self::URL, (string) $url);
	}


	/**
	 * @param string $url
	 *
	 * @dataProvider getNormalizeUrlTestData
	 */
	public function testNormalizeUrl(string $url): void
	{
		Assert::same(self::URL, (new Url($url))->getValue());
	}


	public function testThrowExceptionOnInvalidUrl(): void
	{
		Assert::exception(
			function () {
				new Url('');
			},
			\AipNg\ValueObjects\InvalidArgumentException::class
		);
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


(new UrlTest)->run();
