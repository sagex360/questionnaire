<?php

namespace App\Tests\Http\Controller;

use App\Entity\Form;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class FormResponseControllerTest extends AbstractRestTestCase
{
    /** @test */
    public function shouldReturnUuid()
    {
        /** @var Form $form */
        $form = $this->entityManager->getRepository(Form::class)->findOneBy([]);
        $data = [
            'form' => $form->getId(),
            'answers' => [],
        ];
        foreach ($form->getQuestions() as $question) {
            $data['answers'][] = [
                'question' => $question->getId(),
                'answer' => $this->faker->sentence,
            ];
        }

        $response = $this->sendPost(
            '/api/response',
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
            'form' => 'test',
            'answers' => [
                [
                    'question' => 'test',
                    'answer' => '',
                ],
                [
                    'question' => null,
                    'answer' => $this->faker->sentences(15, true),
                ],
            ],
        ];

        $response = $this->sendPost(
            '/api/response',
            $data,
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertArrayHasKey('errors', $responseData);
        $this->assertEquals('ENTITY_NOT_FOUND', $responseData['errors']['form']);
        $this->assertEquals('ENTITY_NOT_FOUND', $responseData['errors']['answers[0].question']);
        $this->assertEquals('IS_BLANK_ERROR', $responseData['errors']['answers[0].answer']);
        $this->assertEquals('IS_BLANK_ERROR', $responseData['errors']['answers[0].answer']);
        $this->assertEquals('IS_BLANK_ERROR', $responseData['errors']['answers[1].question']);
        $this->assertEquals('TOO_LONG_ERROR', $responseData['errors']['answers[1].answer']);
    }
}
