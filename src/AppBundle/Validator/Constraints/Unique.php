<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Constraint for the unique entity validator
 *
 * @Annotation
 */
class Unique extends UniqueEntity
{
    public $service = 'neo4j.validator.unique';
}
