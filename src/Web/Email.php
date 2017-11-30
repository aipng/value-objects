<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Web;

use AipNg\ValueObjects\Helpers\StringNormalizer;
use AipNg\ValueObjects\InvalidArgumentException;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

final class Email
{

	/** @var string */
	private $value;


	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public function __construct(string $value)
	{
		$value = StringNormalizer::normalizeMandatory($value);

		if (!Validators::isEmail($value)) {
			throw new InvalidArgumentException(
				sprintf("'%s' is not a valid e-mail address!", $value)
			);
		}

		$this->value = Strings::lower($value);
	}


	public function getValue(): string
	{
		return $this->value;
	}


	public function __toString(): string
	{
		return $this->getValue();
	}

}
