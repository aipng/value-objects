<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Helpers;

use AipNg\ValueObjects\Helpers\StringNormalizer;
use PHPUnit\Framework\TestCase;

final class StringNormalizerTest extends TestCase
{

	public function testShouldNormalizeInput(): void
	{
		$this->assertSame('a@a.a', StringNormalizer::normalize("\t\t a@a.a \n"));
		$this->assertNull(StringNormalizer::normalize(null));
		$this->assertNull(StringNormalizer::normalize(''));
		$this->assertNull(StringNormalizer::normalize('   '));
	}

}
