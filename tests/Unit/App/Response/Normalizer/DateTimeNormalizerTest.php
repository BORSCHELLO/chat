<?php

declare(strict_types=1);

namespace App\Tests\Response\Normalizer;

use App\Profile\Entity\User;
use App\Response\Normalizer\DateTimeNormalizer;
use App\Response\Room\Normalizer\UserNormalizer;
use App\Tests\Unit\TestPrivateHelper;
use PHPUnit\Framework\TestCase;

class DateTimeNormalizerTest extends TestCase
{
    public function testNormalize()
    {
       $date = new \DateTime();

       $normalized = (new DateTimeNormalizer())->normalize($date);

       $this->assertEquals($date->format('Y-m-d H:i:s'), $normalized);
    }
}
