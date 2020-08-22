<?php

declare(strict_types=1);

namespace Tests\Unit\App\Room\Entity;

use App\Tests\Unit\TestPrivateHelper;
use App\Room\Entity\Room;
use App\User\Entity\User;
use PHPUnit\Framework\TestCase;

class RoomTest extends TestCase
{
    public function testGetters()
    {
        $room = new Room();
        $user= new User();

        $helper = new TestPrivateHelper($room);
        $helper->set('id', 1);
        $helper->set('user', $user);
        $helper->set('title', 'test');
        $helper->set('public', false);
        $helper->set('enabled', true);

        $this->assertEquals(1, $room->getId());
        $this->assertSame($user, $room->getUser());
        $this->assertEquals('test', $room->getTitle());
        $this->assertFalse($room->isPublic());
        $this->assertTrue($room->isEnabled());
    }

    public function testSetters()
    {
        $room= new Room();
        $user= new User();

        $room->setUser($user);
        $this->assertSame($user, $room->getUser());

        $room->setTitle('test');
        $this->assertSame('test', $room->getTitle());

        $room->setEnabled(false);
        $this->assertFalse($room->isEnabled());

        $room->setEnabled(true);
        $this->assertTrue($room->isEnabled());

        $room->setPublic(false);
        $this->assertFalse($room->isPublic());

        $room->setPublic(true);
        $this->assertTrue($room->isPublic());
    }
}
