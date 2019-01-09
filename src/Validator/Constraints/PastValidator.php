<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PastValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($value > new \DateTime()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%date%', $value->format('d/m/Y'))
                ->atPath('birth')
                ->addViolation();
        }
    }
}
