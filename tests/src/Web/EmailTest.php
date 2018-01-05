<?php

declare(strict_types = 1);

namespace AipNg\Tests\ValueObjects\Web;

use AipNg\ValueObjects\InvalidArgumentException;
use AipNg\ValueObjects\Web\Email;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{

	private const EMAIL = 'test+test@example.org';


	public function testValueObject(): void
	{
		$email = new Email(self::EMAIL);

		$this->assertSame(self::EMAIL, $email->getValue());
	}


	public function testThrowExceptionOnInvalidEmail(): void
	{
		$this->expectException(InvalidArgumentException::class);

		new Email('');
	}


	public function testToString(): void
	{
		$this->assertSame(self::EMAIL, (string) new Email(self::EMAIL));
	}


	public function testNormalizeEmailAddress(): void
	{
		$this->assertSame(self::EMAIL, (string) new Email('  ' . self::EMAIL . '  '));
		$this->assertSame(self::EMAIL, (string) new Email(strtoupper(self::EMAIL)));
	}

}
