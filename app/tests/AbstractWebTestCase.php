<?php

namespace App\Tests;

use Faker;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    use TransactionalTrait;

    /**
     * @var KernelBrowser
     */
    protected KernelBrowser $client;

    /**
     * @var Generator
     */
    protected Generator $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient([
            'environment' => 'test',
            'debug' => true,
        ]);

        $this->beginTransaction();

        $this->faker = Faker\Factory::create();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}
