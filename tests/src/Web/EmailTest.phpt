<?php

declare(strict_types = 1);

namespace AipNg\Tests\ValueObjects\Web;

require __DIR__ . '/../../bootstrap.php';

use AipNg\ValueObjects\InvalidArgumentException;
use AipNg\ValueObjects\Web\Email;
use Tester\Assert;
use Tester\TestCase;

/**
 * @phpExtension mbstring
 */
final class EmailTest extends TestCase
{

	private const EMAIL = 'test+test@example.org';


	public function testValueObject(): void
	{
		$email = new Email(self::EMAIL);

		Assert::same(self::EMAIL, $email->getValue());
	}


	public function testThrowExceptionOnInvalidEmail(): void
	{
		Assert::exception(
			function (): void {
				new Email('');
			},
			InvalidArgumentException::class
		);
	}


	public function testToString(): void
	{
		Assert::same(self::EMAIL, (string) new Email(self::EMAIL));
	}


	public function testNormalizeEmailAddress(): void
	{
		Assert::same(self::EMAIL, (string) new Email('  ' . self::EMAIL . '  '));
		Assert::same(self::EMAIL, (string) new Email(strtoupper(self::EMAIL)));
	}

}


(new EmailTest)->run();
