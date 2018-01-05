<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Helpers;

final class StringNormalizer
{

	/**
	 * Normalizes empty strings in input to null value
	 *
	 * @param mixed $value
	 *
	 * @return mixed|null
	 */
	public static function normalize($value)
	{
		if (!is_string($value)) {
			return $value;
		}

		return self::normalizeString($value);
	}


	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public static function normalizeRecursive($value)
	{
		if (!is_array($value)) {
			return self::normalize($value);
		}

		return array_map(function ($v) {
			return self::normalizeRecursive($v);
		}, $value);
	}


	/**
	 * @param mixed $value
	 * @param string $message
	 *
	 * @return mixed
	 *
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public static function normalizeMandatory($value, string $message = 'Mandatory value, must be filled!')
	{
		if (!is_string($value)) {
			return $value;
		}

		$value = self::normalizeString($value);

		if (!$value) {
			throw new \AipNg\ValueObjects\InvalidArgumentException($message);
		}

		return $value;
	}


	private static function normalizeString(string $string): ?string
	{
		return trim($string) ?: null;
	}

}
