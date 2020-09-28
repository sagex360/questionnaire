<?php

namespace App\Tests\Http\Controller;

use App\Entity\Form;

class FormControllerTest extends AbstractRestTestCase
{
    /** @test */
    public function shouldReturnFormData()
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
            sprintf('/api/form/%s', $form->getId()),
            [],
            $this->token
        );

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($form->getId(), $responseData['id']);
        $this->assertEquals($form->getName(), $responseData['name']);
        $this->assertArrayHasKey('questions', $responseData);
        $this->assertArrayNotHasKey('responses', $responseData);
    }
}
