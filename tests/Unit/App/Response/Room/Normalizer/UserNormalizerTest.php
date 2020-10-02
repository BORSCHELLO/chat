<?php

declare(strict_types=1);

namespace App\Tests\Response\Room\Normalizer;

use App\Profile\Entity\User;
use App\Response\Room\Normalizer\UserNormalizer;
use App\Tests\Unit\TestPrivateHelper;
use PHPUnit\Framework\TestCase;

class UserNormalizerTest extends TestCase
{
    public function testNormalize()
    {
        $user = new User();
        $user->setName('test');

        $refUser = new TestPrivateHelper($user);
        $refUser->set('id', 2);

        $normalized = (new UserNormalizer())->normalize($user);

        $this->assertArrayHasKey('id', $normalized);
        $this->assertEquals(2, $normalized['id']);
        $this->assertArrayHasKey('name', $normalized);
        $this->assertEquals('test', $normalized['name']);
    }
}