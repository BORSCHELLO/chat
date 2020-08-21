<?php

declare(strict_types=1);

namespace Tests\Unit\App\Room\Entity;

use App\Tests\Unit\TestPrivateHelper;
use App\Room\Entity\Message;
use App\User\Entity\User;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testGetters()
    {
        $message = new Message();
        $user= new User();

        $helper = new TestPrivateHelper($message);
        $helper->set('id', 1);
        $helper->set('message', 'test message');
        $helper->set('created_at','2020-08-07 12:11:53');
        $helper->set('user',$user);

        $this->assertEquals(1, $message->getId());
        $this->assertEquals('test message', $message->getMessage());
        $this->assertEquals('2020-08-07 12:11:53', $message->getCreatedAt());
        $this->assertEquals($user, $message->getUser());
    }

    public function testSetters()
    {
        $message= new Message();
        $user= new User();

        $message->setMessage('test');
        $this->assertEquals('test', $message->getMessage());

        $message->setCreatedAt('2020-08-07 12:11:53');
        $this->assertEquals('2020-08-07 12:11:53', $message->getCreatedAt());

        $message->setUser($user);
        $this->assertEquals($user, $message->getUser());
    }
}
