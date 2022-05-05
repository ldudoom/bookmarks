<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] class AccesibleUrl extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */

    public string $message = 'The provided url "{{ url }}" is not accessible ({{ statusCode }}).';

}
