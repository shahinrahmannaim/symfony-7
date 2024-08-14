<?php

namespace App\tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $user = new User();
        $username = 'mickael';
        $password = 'password';
        $email = 'mickael@gmail.fr';

        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);

        $this->assertSame($username, $user->getUsername());
        $this->assertSame($password, $user->getPassword());
        $this->assertSame($email, $user->getEmail());
    }

    public function testRoles()
    {
        $user = new User();
        $user->setEmail('mickael@gmail.fr');

        $roles = $user->getRoles();
        $this->assertContains('ROLE_USER', $roles);
        $this->assertContains('ROLE_ADMIN', $roles);
    }

    public function testVerifiedRoles()
    {
        $user = new User();
        $user->setVerified(true);

        $roles = $user->getRoles();
        $this->assertContains('ROLE_VERIFIED', $roles);
    }
}
