<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class BadWord extends Constraint
{
    public $message = 'The text contains a bad word: "{{ value }}".';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}