<?php

namespace App\Tests;

use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Faker;

abstract class AbstractKernelTestCase extends KernelTestCase
{
    use TransactionalTrait;

    /**
     * @var Generator
     */
    protected Generator $faker;

    protected function setUp()
    {
        parent::setUp();

        static::$kernel = static::bootKernel();

        $this->faker = Faker\Factory::create();

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}
