<?php

namespace App\Http\Request;

use App\Converter\DtoConverter;
use Ramsey\Uuid\Validator\ValidatorInterface;

class RequestDataHandler
{
    /**
     * @var DtoConverter
     */
    private DtoConverter $dtoConverter;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(DtoConverter $dtoConverter, ValidatorInterface $validator)
    {
        $this->dtoConverter = $dtoConverter;
        $this->validator = $validator;
    }

    public function handle()
    {

    }
}
