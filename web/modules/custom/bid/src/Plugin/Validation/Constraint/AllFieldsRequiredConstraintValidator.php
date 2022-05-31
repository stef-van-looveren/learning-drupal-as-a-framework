<?php

namespace Drupal\bid\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates our AllFieldsRequired constraint
 */
class AllFieldsRequiredConstraintValidator extends ConstraintValidator {
  public function validate($entity, Constraint $constraint)
  {
    if ($entity->get('user_id')->isEmpty()) {
      $this->context->addViolation($constraint->message);
    }
    if ($entity->get('bid')->isEmpty()) {
      $this->context->addViolation($constraint->message);
    }
    if ($entity->get('offer_id')->isEmpty()) {
      $this->context->addViolation($constraint->message);
    }
  }
}
