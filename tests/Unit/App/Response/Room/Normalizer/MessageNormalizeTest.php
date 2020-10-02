<?php

declare(strict_types=1);

namespace App\Tests\Response\Room\Normalizer;

use App\Profile\Entity\User;
use App\Response\Room\Normalizer\MessageNormalizer;
use App\Room\Entity\Message;
use App\Tests\Unit\TestPrivateHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MessageNormalizeTest extends TestCase
{
    public function testNormalize()
    {
        $message = new Message();
        $helper = new TestPrivateHelper($message);
        $message->setMessage('test')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUser(new User());
        $helper->set('id',1);

        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $normalizerMock->expects($this->any())
            ->method('normalize')
            ->willReturn('ok');

        $normalizer = new MessageNormalizer();
        $normalizer->setNormalizer($normalizerMock);

        $normalized = $normalizer->normalize($message);

        $this->assertArrayHasKey('id', $normalized);
        $this->assertEquals(1, $normalized['id']);
        $this->assertArrayHasKey('message', $normalized);
        $this->assertEquals('test', $normalized['message']);
        $this->assertArrayHasKey('createdAt', $normalized);
        $this->assertEquals('ok', $normalized['createdAt']);
        $this->assertArrayHasKey('user', $normalized);
        $this->assertEquals('ok', $normalized['user']);
    }
}
