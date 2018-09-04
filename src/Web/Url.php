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
	public function __construct(string $value)
	{
		$value = StringNormalizer::normalizeMandatory($value);

		if (!Validators::isUrl($value)) {
			throw new InvalidArgumentException(sprintf(
				'\'%s\' is not a valid URL!',
				$value
			));
		}

		$this->value = $value;
	}

}
