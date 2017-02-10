<?php

declare(strict_types=1);

namespace AuthenticationTest;

use Authentication\UserEmail;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Authentication\UserEmail
 */
final class UserEmailTest extends TestCase
{
    public function test_accepts_a_valid_email_address() : void
    {
        $email = UserEmail::fromString('me@example.com');

        self::assertInstanceOf(UserEmail::class, $email);
        self::assertSame('me@example.com', $email->toString());
    }

    /**
     * @dataProvider invalidValuesProvider
     */
    public function test_rejects_an_invalid_email_address(string $invalidEmail) : void
    {
        $this->expectException(\InvalidArgumentException::class);

        UserEmail::fromString($invalidEmail);
    }

    public function invalidValuesProvider() : array
    {
        return [
            [''],
            ['*'],
            ['foo'],
            [' me@example.com'],
            ['me@example.com '],
            ['me@ example.com'],
            ['@realDonaldTrump'],
        ];
    }
}
