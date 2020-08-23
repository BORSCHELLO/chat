<?php

declare(strict_types=1);

namespace Tests\Unit\App\Room\Entity;

use App\Tests\Unit\TestPrivateHelper;
use App\Room\Entity\Message;
use App\Profile\Entity\User;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testGetters()
    {
        $message = new Message();
        $user= new User();
        $date = new \DateTimeImmutable();

        $helper = new TestPrivateHelper($message);
        $helper->set('id', 1);
        $helper->set('message', 'test message');
        $helper->set('createdAt',$date);

        $helper->set('user',$user);

        $this->assertEquals(1, $message->getId());
        $this->assertEquals('test message', $message->getMessage());
        $this->assertEquals($date, $message->getCreatedAt());
        $this->assertEquals($user, $message->getUser());
    }

    public function testSetters()
    {
        $message= new Message();
        $user= new User();
        $date = new \DateTimeImmutable();


        $message->setMessage('test');
        $this->assertEquals('test', $message->getMessage());

        $message->setCreatedAt($date);
        $this->assertEquals($date->format('Y-m-d H:i:s'), $message->getCreatedAt()->format('Y-m-d H:i:s'));

        $message->setUser($user);
        $this->assertEquals($user, $message->getUser());
    }
}
