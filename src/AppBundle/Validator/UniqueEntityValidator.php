<?php

namespace AppBundle\Validator;

use AppBundle\Manager\GraphManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEntityValidator extends ConstraintValidator
{
    /** @var GraphManager $em */
    protected $em;

    public function __construct(GraphManager $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function validate($entity, Constraint $constraint)
    {
        if (!is_array($constraint->fields) && !is_string($constraint->fields)) {
            throw new UnexpectedTypeException($constraint->fields, 'array');
        }

        if (null !== $constraint->errorPath && !is_string($constraint->errorPath)) {
            throw new UnexpectedTypeException($constraint->errorPath, 'string or null');
        }

        $fields = (array)$constraint->fields;
        if (0 === count($fields)) {
            throw new ConstraintDefinitionException('At least one field has to be specified.');
        }

        $className = $this->context->getClassName();

        $repository = $this->em->getRepository($className);

        $meta        = $repository->getMeta();
        $criteria    = array();

        foreach ($fields as $fieldName) {
            if (!$property = $this->findProperty($fieldName, $meta)) {
                throw new ConstraintDefinitionException(sprintf("The field '%s' is not mapped, so it cannot be validated for uniqueness.",
                    $fieldName));
            }

            if ($property->isRelation() || $property->isRelationList()) {
                throw new ConstraintDefinitionException(sprintf("The field '%s' has a relation, so it cannot be validated for uniqueness currently.",
                    $fieldName));
            }
            if (null !== $property->getValue($entity)) {
                $criteria[$fieldName] = $property->getValue($entity);
            }
        }

        $result = array();
        if (count($criteria) > 0) {
            $result = $repository->findBy($criteria);
        }
        if (0 === count($result)) {
            return;
        }
        if (1 === count($result)) {
            if ($entity->getId() == $result[0]->getId()) {
                return;
            }
        }
        $errorPath = null !== $constraint->errorPath ? $constraint->errorPath : $fields[0];
        $this->context->addViolationAt($errorPath, $constraint->message, array(), $criteria[$fields[0]]);
    }

    private function findProperty($name, $meta)
    {
        foreach ($meta->getProperties() as $p) {
            if ($p->getName() == $name) {
                return $p;
            }
        }
        foreach ($meta->getManyToManyRelations() as $p) {
            if ($p->getName() == $name) {
                return $p;
            }
        }
        foreach ($meta->getManyToOneRelations() as $p) {
            if ($p->getName() == $name) {
                return $p;
            }
        }

        return false;
    }

}
