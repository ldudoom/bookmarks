<?php

namespace App\Validator;

use App\Interfaces\CustomHttpClientInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AccesibleUrlValidator extends ConstraintValidator
{
    protected CustomHttpClientInterface $_customHttpClient;

    public function __construct(CustomHttpClientInterface $customHttpClient)
    {
        $this->_customHttpClient = $customHttpClient;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $statusCode = $this->_customHttpClient->getUrlCode($value);

        if($statusCode === -1){
            $statusCode = 'Http Error';
        }

        if($statusCode >= 400){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ url }}', $value)
                ->setParameter('{{ statusCode }}', 'HTTP STATUS: '.$statusCode)
                ->addViolation();
        }
    }
}
