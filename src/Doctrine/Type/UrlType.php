<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Doctrine\Type;

use AipNg\ValueObjects\Web\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class UrlType extends Type
{

	private const NAME = 'url';


	/**
	 * @param mixed[] $column
	 * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
	 *
	 * @return string
	 */
	public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
	{
		return $platform->getStringTypeDeclarationSQL($column);
	}


	public function getName(): string
	{
		return self::NAME;
	}


	public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
	{
		return $value instanceof Url ? $value->getValue() : null;
	}


	public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Url
	{
		if ($value instanceof Url) {
			return $value;
		}

		return is_string($value) ? new Url($value) : null;
	}

}
