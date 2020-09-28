<?php

namespace App\DataFixtures;

use App\Entity\Form;
use App\Entity\FormResponse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    /**
     * @var Faker\Generator
     */
    private Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->createForms($manager);

        $manager->flush();
    }

    private function createForms(ObjectManager $manager, int $count = 5)
    {
        for ($i = 0; $i < $count; $i++) {
            $form = new Form(Uuid::uuid4(), $this->faker->words(2, true));
            $form->addQuestion(Uuid::uuid4(), $this->faker->sentence);

            $manager->persist($form);
        }

        for ($i = 0; $i < $count; $i++) {
            $form = new Form(Uuid::uuid4(), $this->faker->words(true, 2));
            $form->addQuestion(Uuid::uuid4(), $this->faker->sentence);

            $this->createResponses($manager, $form);

            $manager->persist($form);
        }
    }

    private function createResponses(ObjectManager $manager, Form  $form, int $count = 5)
    {
        for ($i = 0; $i < $count; $i++) {
            $response = new FormResponse(Uuid::uuid4(), $form);
            foreach ($form->getQuestions() as $question) {
                $response->addAnswer(Uuid::uuid4(), $question, $this->faker->sentence);
            }

            $manager->persist($response);
        }
    }
}
