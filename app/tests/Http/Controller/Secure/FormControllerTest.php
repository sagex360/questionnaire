<?php

namespace App\Tests\Http\Controller\Secure;

use App\Entity\Form;
use App\Tests\Http\Controller\AbstractRestTestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class FormControllerTest extends AbstractRestTestCase
{
    /** @test */
    public function shouldReturnFormList()
    {
        $response = $this->sendGet(
            sprintf('/api/secure/form?%s', http_build_query(['_limit' => 5])),
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(5, $responseData);
    }

    /** @test */
    public function shouldReturnFormWithResponses()
    {
        /** @var Form $form */
        $form = $this->entityManager->createQueryBuilder()
            ->select('f')
            ->from(Form::class, 'f')
            ->where('f.responses IS NOT EMPTY')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        $response = $this->sendGet(
            sprintf('/api/secure/form/%s', $form->getId()),
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($form->getId(), $responseData['id']);
        $this->assertEquals($form->getName(), $responseData['name']);
        $this->assertArrayHasKey('questions', $responseData);
        $this->assertArrayHasKey('responses', $responseData);
    }

    /** @test */
    public function shouldReturnFormRatioStatistics()
    {
        $response = $this->sendGet(
            '/api/secure/form/statistics/ratio',
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(5, $responseData['withResponse']);
        $this->assertEquals(5, $responseData['withNoResponse']);
    }

    /** @test */
    public function shouldReturnUuid()
    {
        $data = [
            'name' => $this->faker->words(2, true),
            'questions' => [
                [
                    'question' => $this->faker->sentence,
                ],
                [
                    'question' => $this->faker->sentence,
                ],
            ],
        ];

        $response = $this->sendPost(
            '/api/secure/form',
            $data,
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $responseData);
        $this->assertTrue(Uuid::isValid($responseData['id']));

        /** @var InMemoryTransport $transport */
        $transport = self::$container->get('messenger.transport.async');
        $this->assertCount(1, $transport->get());
    }

    /** @test */
    public function shouldReturnValidationErrors()
    {
        $data = [
            'name' => '',
            'questions' => [
                [
                    'question' => $this->faker->sentences(15, true),
                ],
                [
                    'question' => '',
                ],
            ],
        ];

        $response = $this->sendPost(
            '/api/secure/form',
            $data,
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertArrayHasKey('errors', $responseData);
        $this->assertEquals('IS_BLANK_ERROR', $responseData['errors']['name']);
        $this->assertEquals('TOO_LONG_ERROR', $responseData['errors']['questions[0].question']);
        $this->assertEquals('IS_BLANK_ERROR', $responseData['errors']['questions[1].question']);
    }

    /** @test */
    public function shouldDenyAccess()
    {
        $response = $this->sendGet(
            sprintf('/api/secure/form?%s', http_build_query(['_limit' => 5])),
            [],
        );

        $this->assertEquals(403, $response->getStatusCode());
    }
}
