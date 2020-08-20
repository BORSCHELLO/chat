<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineTestCase extends KernelTestCase
{
    protected EntityManager $em;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        /** @var EntityManager $em */
        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropSchema($this->em->getMetadataFactory()->getAllMetadata());
        $schemaTool->createSchema($this->em->getMetadataFactory()->getAllMetadata());
    }
}
