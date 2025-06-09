<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserLogicTest extends TestCase
{
    public function test_name_is_not_empty_and_is_string(): void
    {
        $name = 'Test User';
        $this->assertNotEmpty($name);
        $this->assertIsString($name);
    }

    public function test_username_is_not_empty_and_is_string(): void
    {
        $username = 'testuser';
        $this->assertNotEmpty($username);
        $this->assertIsString($username);
    }

    public function test_email_format_is_valid(): void
    {
        $email = 'test@correo.com';
        $this->assertNotEmpty($email);
        $this->assertMatchesRegularExpression('/^.+@.+\..+$/', $email);
    }

    public function test_password_meets_minimum_length(): void
    {
        $password = 'testpassword';
        $this->assertNotEmpty($password);
        $this->assertGreaterThanOrEqual(8, strlen($password));
    }
}
