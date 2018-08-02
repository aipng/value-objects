<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Helpers;

use AipNg\ValueObjects\Helpers\StringNormalizer;
use AipNg\ValueObjects\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class StringNormalizerTest extends TestCase
{

	public function testNormalizeEmptyStrings(): void
	{
		$this->assertNull(StringNormalizer::normalize(null));
		$this->assertNull(StringNormalizer::normalize(''));
		$this->assertNull(StringNormalizer::normalize('   '));
	}


	public function testTrimWhiteSpaces(): void
	{
		$this->assertSame('trim spaces', StringNormalizer::normalize('  trim spaces  '));
	}


	public function testHandlePrimitiveTypes(): void
	{
		$this->assertSame(1, StringNormalizer::normalize(1));
		$this->assertSame(0, StringNormalizer::normalize(0));
		$this->assertSame('string', StringNormalizer::normalize('string'));
		$this->assertTrue(StringNormalizer::normalize(true));
		$this->assertFalse(StringNormalizer::normalize(false));
	}


	public function testHandleArrays(): void
	{
		$this->assertSame([], StringNormalizer::normalize([]));
		$this->assertSame([''], StringNormalizer::normalize(['']));
		$this->assertSame([true], StringNormalizer::normalize([true]));
	}


	public function testHandleObject(): void
	{
		$object = new \stdClass;
		$this->assertSame($object, StringNormalizer::normalize($object));
	}


	public function testRecursiveNormalization(): void
	{
		$this->assertSame([null], StringNormalizer::normalizeRecursive(['']));
		$this->assertSame([[null]], StringNormalizer::normalizeRecursive([[' ']]));
	}


	public function testMandatoryNormalizationOfArray(): void
	{
		$this->assertSame([], StringNormalizer::normalizeMandatory([]));
	}


	public function testNormalizeMandatoryThrowExceptionOnEmptyString(): void
	{
		$this->expectException(InvalidArgumentException::class);

		StringNormalizer::normalizeMandatory('');
	}

}
