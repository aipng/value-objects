<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Common;

use AipNg\ValueObjects\InvalidArgumentException;

abstract class StringBasedObject
{

	/** @var string */
	protected $value;


	public function getValue(): string
	{
		return $this->value;
	}


	public function __toString(): string
	{
		return $this->getValue();
	}


	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public function equals(self $object): bool
	{
		if (get_class($this) !== get_class($object)) {
			throw new InvalidArgumentException('Operation supported on same object type only!');
		}

		return $this->value === $object->getValue();
	}


	public function equalsValue(string $value): bool
	{
		return $this->value === $value;
	}

}
