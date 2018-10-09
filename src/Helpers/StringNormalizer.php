<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Helpers;

final class StringNormalizer
{

	/**
	 * Trims input and normalizes empty strings to null
	 */
	public static function normalize(?string $input): ?string
	{
		if ($input === null) {
			return null;
		}

		return self::trim($input) ?: null;
	}


	private static function trim(string $input): string
	{
		return trim($input, " \t\n\r\0\x0B\xC2\xA0");
	}

}
