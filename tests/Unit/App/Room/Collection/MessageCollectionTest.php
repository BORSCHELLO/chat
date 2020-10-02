<?php

declare(strict_types=1);

namespace Tests\Unit\App\Room\Collection;

use App\Profile\Entity\User;
use App\Room\Collection\MessageCollection;
use App\Room\Entity\Message;
use PHPUnit\Framework\TestCase;

class MessageCollectionTest extends TestCase
{
    public function testSort()
    {
        $message1 = new Message();
        $message1->setMessage('test1');
        $message2 = new Message();
        $message2->setMessage('test2');
        $message3 = new Message();
        $message3->setMessage('test3');
        $collection = new MessageCollection([$message1, $message2, $message3]);

        $test = [$message1, $message2, $message3];
        sort($test);

        $result = $collection->sort()->toArray();

        $this->assertEquals($test, $result);
    }
}
