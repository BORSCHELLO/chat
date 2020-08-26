<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Entity;

use App\Tests\Unit\TestPrivateHelper;
use App\Profile\Entity\User;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class UserTest extends TestCase
{
    public function testGetters()
    {
        $user = new User();
        $date = new DateTimeImmutable();

        $helper = new TestPrivateHelper($user);
        $helper->set('id', 1);
        $helper->set('name', 'test user');
        $helper->set('lastVisit',$date);



        $this->assertEquals(1, $user->getId());
        $this->assertEquals('test user', $user->getName());
        $this->assertEquals($date, $user->getLastVisit());
    }

    public function testSetters()
    {
        $user = new User();
        $date = new DateTimeImmutable();

        $user->setName('test');
        $this->assertEquals('test', $user->getName());

        $user->setName('test1');
        $this->assertEquals('test1', $user->getName());

        $user->setLastVisit($date);
        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getLastVisit()->format('Y-m-d H:i:s'));
    }
}
