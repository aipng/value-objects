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


	public function testFromConstructor(): void
	{
		$email = Email::from(strtoupper(self::EMAIL));
		$this->assertSame(self::EMAIL, $email->getValue());
	}


	public function testThrowExceptionOnInvalidEmail(): void
	{
		$this->expectException(InvalidArgumentException::class);

		Email::from('  ');
	}


	public function testToString(): void
	{
		$this->assertSame(self::EMAIL, (string) Email::from(self::EMAIL));
	}


	public function testNormalizeEmailAddress(): void
	{
		$this->assertSame(self::EMAIL, (string) Email::from('  ' . self::EMAIL . '  '));
	}


	public function testGetUsername(): void
	{
		$email = Email::from(self::EMAIL);

		$this->assertSame('test+test', $email->getUsername());
	}


	public function testGetDomain(): void
	{
		$email = Email::from(self::EMAIL);

		$this->assertSame('example.org', $email->getDomain());
	}


	public function testEquals(): void
	{
		$original = Email::from(self::EMAIL);
		$copy = Email::from(self::EMAIL);
		$different = Email::from('diff@example.org');

		$this->assertTrue($original->equals($original));
		$this->assertTrue($original->equals($copy));
		$this->assertFalse($original->equals($different));
	}


	public function testEqualsRequiresSameObjectClass(): void
	{
		$this->expectException(InvalidArgumentException::class);

		(Email::from(self::EMAIL))->equals(new Url('http://example.org'));
	}


	public function testEqualsValue(): void
	{
		$this->assertTrue((Email::from(self::EMAIL))->equalsValue(self::EMAIL));
	}

}
