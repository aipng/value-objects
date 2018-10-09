<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Web;

use AipNg\ValueObjects\InvalidArgumentException;
use AipNg\ValueObjects\Web\Email;
use AipNg\ValueObjects\Web\Url;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{

	private const EMAIL = 'test+test@example.org';


	public function testEmailIsCaseSensitive(): void
	{
		$email = 'Example@example.org';

		$this->assertSame($email, (new Email($email))->getValue());
	}


	public function testLowerConstructor(): void
	{
		$email = Email::lower(strtoupper(self::EMAIL));
		$this->assertSame(self::EMAIL, $email->getValue());
	}


	public function testThrowExceptionOnInvalidEmail(): void
	{
		$this->expectException(InvalidArgumentException::class);

		new Email('  ');
	}


	public function testToString(): void
	{
		$this->assertSame(self::EMAIL, (string) new Email(self::EMAIL));
	}


	public function testNormalizeEmailAddress(): void
	{
		$this->assertSame(self::EMAIL, (string) new Email('  ' . self::EMAIL . '  '));
	}


	public function testEquals(): void
	{
		$original = new Email(self::EMAIL);
		$copy = new Email(self::EMAIL);
		$different = new Email('diff@example.org');

		$this->assertTrue($original->equals($original));
		$this->assertTrue($original->equals($copy));
		$this->assertFalse($original->equals($different));
	}


	public function testEqualsRequiresSameObjectClass(): void
	{
		$this->expectException(InvalidArgumentException::class);

		(new Email(self::EMAIL))->equals(new Url('http://example.org'));
	}


	public function testEqualsValue(): void
	{
		$this->assertTrue((new Email(self::EMAIL))->equalsValue(self::EMAIL));
	}

}
