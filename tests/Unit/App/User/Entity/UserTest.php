<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Entity;

use App\Tests\Unit\TestPrivateHelper;
use App\User\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetters()
    {
        $user = new User();

        $helper = new TestPrivateHelper($user);
        $helper->set('id', 1);
        $helper->set('name', 'test user');

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('test user', $user->getName());
    }

    public function testSetters()
    {
        $user = new User();
        $user->setName('test');

        $this->assertEquals('test', $user->getName());
        $user->setName('test1');
        $this->assertEquals('test1', $user->getName());
    }
}
