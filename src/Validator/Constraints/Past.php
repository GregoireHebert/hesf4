<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Past extends Constraint
{
    public $message = 'La date %date% est dans le futur';
}
