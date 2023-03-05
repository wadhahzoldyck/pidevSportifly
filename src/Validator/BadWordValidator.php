<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BadWordValidator extends ConstraintValidator
{
    private $badWords = [
        'fuck',
        'merde',
        'putain',
        'bitch',
    ];

    public function validate($value, Constraint $constraint)
    {
        if (preg_match('/\b('.implode('|', $this->badWords).')\b/i', $value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

}