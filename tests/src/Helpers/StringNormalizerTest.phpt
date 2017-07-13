<?php

declare(strict_types = 1);

namespace AipNg\Tests\ValueObjects\Helpers;

require __DIR__ . '/../../bootstrap.php';

use AipNg\ValueObjects\Helpers\StringNormalizer;
use Tester\Assert;
use Tester\TestCase;

final class StringNormalizerTest extends TestCase
{

	public function testNormalizeEmptyStrings(): void
	{
		Assert::null(StringNormalizer::normalize(NULL));
		Assert::null(StringNormalizer::normalize(''));
		Assert::null(StringNormalizer::normalize('   '));
	}


	public function testTrimWhiteSpaces(): void
	{
		Assert::same('trim spaces', StringNormalizer::normalize('  trim spaces  '));
	}


	public function testHandlePrimitiveTypes(): void
	{
		Assert::same(1, StringNormalizer::normalize(1));
		Assert::same(0, StringNormalizer::normalize(0));
		Assert::same('string', StringNormalizer::normalize('string'));
		Assert::same(TRUE, StringNormalizer::normalize(TRUE));
		Assert::same(FALSE, StringNormalizer::normalize(FALSE));
	}


	public function testHandleArrays(): void
	{
		Assert::same([], StringNormalizer::normalize([]));
		Assert::same([''], StringNormalizer::normalize(['']));
		Assert::same([TRUE], StringNormalizer::normalize([TRUE]));
	}


	public function testHandleObject(): void
	{
		$object = new \stdClass;
		Assert::same($object, StringNormalizer::normalize($object));
	}


	public function testRecursiveNormalization(): void
	{
		Assert::same([NULL], StringNormalizer::normalizeRecursive(['']));
		Assert::same([[NULL]], StringNormalizer::normalizeRecursive([[' ']]));
	}


	public function testMandatoryNormalizationOfArray(): void
	{
		Assert::same([], StringNormalizer::normalizeMandatory([]));
	}


	public function testNormalizeMandatoryThrowExceptionOnEmptyString(): void
	{
		Assert::exception(function () {
			StringNormalizer::normalizeMandatory('');
		}, \AipNg\ValueObjects\InvalidArgumentException::class);
	}

}


(new StringNormalizerTest)->run();
