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
	 * @param mixed[] $fieldDeclaration
	 * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
	 *
	 * @return string
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
	{
		return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
	}


	public function getName(): string
	{
		return self::NAME;
	}


	/**
	 * @param mixed|\AipNg\ValueObjects\Web\Url $value
	 * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
	 *
	 * @return string
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
	{
		return $value ? $value->getValue() : null;
	}


	/**
	 * @param mixed|string $value
	 * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
	 *
	 * @return \AipNg\ValueObjects\Web\Url
	 *
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform): ?Url
	{
		if ($value instanceof Url) {
			return $value;
		}

		return $value ? new Url($value) : null;
	}

}
