<?php

declare(strict_types=1);

namespace AuthenticationTest\Entity;

use Authentication\ClearTextPassword;
use Authentication\Entity\User;
use Authentication\Repository\Users;
use Authentication\UserEmail;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Authentication\Entity\User
 */
final class UserTest extends TestCase
{
    /**
     * @var UserEmail
     */
    private $emailAddress;

    /**
     * @var ClearTextPassword
     */
    private $password;

    /**
     * @var User|\PHPUnit_Framework_MockObject_MockObject
     */
    private $existingUsers;

    protected function setUp() : void
    {
        parent::setUp();

        $this->emailAddress  = UserEmail::fromString(uniqid('foo', true) . '@example.com');
        $this->password      = ClearTextPassword::fromString(uniqid('pA$$w0rd', true));
        $this->existingUsers = $this->createMock(Users::class);

    }

    public function test_it_will_register_a_non_existing_user() : void
    {
        $this->existingUsers
            ->expects(self::any())
            ->method('has')
            ->with(self::equalTo($this->emailAddress))
            ->willReturn(false);

        $user = User::register(
            $this->existingUsers,
            $this->emailAddress,
            $this->password
        );

        self::assertInstanceOf(User::class, $user);
    }

    public function test_it_will_reject_registering_already_existing_user() : void
    {
        $this->existingUsers
            ->expects(self::any())
            ->method('has')
            ->with(self::equalTo($this->emailAddress))
            ->willReturn(true);

        $this->expectException(\LogicException::class);

        User::register(
            $this->existingUsers,
            $this->emailAddress,
            $this->password
        );
    }
}
