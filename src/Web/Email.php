<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Web;

use AipNg\ValueObjects\Common\StringBasedObject;
use AipNg\ValueObjects\Helpers\StringNormalizer;
use AipNg\ValueObjects\InvalidArgumentException;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

final class Email extends StringBasedObject
{

	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public function __construct(string $input)
	{
		$input = StringNormalizer::normalize($input);

		if ($input === null || !Validators::isEmail($input)) {
			throw new InvalidArgumentException(sprintf(
				'\'%s\' is not a valid e-mail address!',
				$input
			));
		}

		$this->value = $input;
	}


	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public static function from(string $input): Email
	{
		return new self(Strings::lower($input));
	}


	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 * @deprecated
	 */
	public static function lower(string $input): Email
	{
		trigger_error('Email::lower deprecated, use Email::from instead!', E_USER_NOTICE);

		return self::from($input);
	}

}
