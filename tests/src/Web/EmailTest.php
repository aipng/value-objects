<?php

declare(strict_types = 1);

namespace AipNg\ValueObjectsTests\Web;

use AipNg\ValueObjects\InvalidArgumentException;
use AipNg\ValueObjects\Web\Email;
use AipNg\ValueObjects\Web\Url;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{

	public function testFromConstructor(): void
	{
		$email = Email::from(strtoupper('test+test@example.org'));
		$this->assertSame('test+test@example.org', $email->getValue());
	}


	public function testThrowExceptionOnInvalidEmail(): void
	{
		$this->expectException(InvalidArgumentException::class);

		Email::from('  ');
	}


	public function testToString(): void
	{
		$this->assertSame('test+test@example.org', (string) Email::from('test+test@example.org'));
	}


	public function testNormalizeEmailAddress(): void
	{
		$this->assertSame('test+test@example.org', Email::from('  test+test@example.org  ')->getValue());
	}


	public function testGetUsername(): void
	{
		$email = Email::from('test+test@example.org');

		$this->assertSame('test+test', $email->getUsername());
	}


	public function testGetDomain(): void
	{
		$email = Email::from('test+test@example.org');

		$this->assertSame('example.org', $email->getDomain());
	}


	public function testEquals(): void
	{
		$original = Email::from('test+test@example.org');
		$copy = Email::from('test+test@example.org');
		$different = Email::from('diff@example.org');

		$this->assertTrue($original->equals($original));
		$this->assertTrue($original->equals($copy));
		$this->assertFalse($original->equals($different));
	}


	public function testEqualsRequiresSameObjectClass(): void
	{
		$this->expectException(InvalidArgumentException::class);

		Email::from('test+test@example.org')->equals(new Url('https://example.org'));
	}


	public function testEqualsValue(): void
	{
		$this->assertTrue(Email::from('test+test@example.org')->equalsValue('test+test@example.org'));
	}

}
