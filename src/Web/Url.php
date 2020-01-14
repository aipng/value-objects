<?php

declare(strict_types = 1);

namespace AipNg\ValueObjects\Web;

use AipNg\ValueObjects\Common\StringBasedObject;
use AipNg\ValueObjects\Helpers\StringNormalizer;
use AipNg\ValueObjects\InvalidArgumentException;
use Nette\Utils\Validators;

final class Url extends StringBasedObject
{

	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public function __construct(string $input)
	{
		$input = StringNormalizer::normalize($input);

		if ($input === null || !Validators::isUrl($input)) {
			throw new InvalidArgumentException(sprintf(
				'\'%s\' is not a valid URL!',
				$input
			));
		}

		$this->value = $input;
	}


	/**
	 * @throws \AipNg\ValueObjects\InvalidArgumentException
	 */
	public static function from(string $input): Url
	{
		return new self($input);
	}

}
