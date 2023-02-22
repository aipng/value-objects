<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Doctrine\Type;

use AipNg\ValueObjects\Web\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class EmailType extends Type
{

	private const NAME = 'email';


	/** @inheritDoc */
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
		return $value instanceof Email ? $value->getValue() : null;
	}


	public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Email
	{
		if ($value instanceof Email) {
			return $value;
		}

		return is_string($value) ? new Email($value) : null;
	}

}
