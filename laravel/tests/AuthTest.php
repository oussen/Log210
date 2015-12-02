<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * This section is for tests on /auth/register
     */
    public function testRegisterAllFieldsEmpty()
    {
        $this->visit('/auth/register')->press('Register')->seePageIs('/auth/register');
    }

    public function testRegisterWrongPass()
    {
        $this->visit('/auth/register')
            ->Type('TestName', 'name')
            ->Type('TestEmail@Test.com', 'email')
            ->Type('1234123', 'phone')
            ->Type('123', 'password')
            ->Type('123', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/auth/register');
    }

    public function testRegisterWrongPassConfirm()
    {
        $this->visit('/auth/register')
            ->Type('TestName', 'name')
            ->Type('TestEmail@Test.com', 'email')
            ->Type('1234123', 'phone')
            ->Type('123456', 'password')
            ->Type('654321', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/auth/register');
    }

    public function testRegisterAllValid()
    {
        $this->visit('/auth/register')
             ->Type('TestName', 'name')
             ->Type('TestEmail@Test.com', 'email')
             ->Type('1234123', 'phone')
             ->Type('123456', 'password')
             ->Type('123456', 'password_confirmation')
             ->press('Register')
             ->seePageIs('/home');
    }

    /**
     * This section is for tests on auth/login
     */

    public function testLoginAllFieldsEmpty()
    {
        $this->visit('/auth/login')->press('Login')->seePageIs('/auth/login');
    }

    public function testLoginWrongPassword()
    {
        $this->visit('/auth/login')
            ->Type('admin@laravel.com', 'login')
            ->Type('654321', 'password')
            ->press('Login')
            ->seePageIs('/auth/login');
    }

    public function testLoginAllValid()
    {
        $this->visit('/auth/login')
            ->Type('514-699-6412', 'login')
            ->Type('123456', 'password')
            ->press('Login')
            ->seePageIs('/auth/login');
    }

}
