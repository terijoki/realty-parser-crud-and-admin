<?php

namespace RltBundle\Manager;

use RltBundle\Entity\User;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    protected ValidatorInterface $validator;

    protected ConstraintViolationListInterface $errors;

    protected string $entityClass;

    protected PropertyAccessorInterface $propertyAccessor;

    /**
     * UserManager constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator) {
        $this->validator = $validator;
        $this->errors = new ConstraintViolationList();
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param User $requestData
     * @param User  $entity
     *
     * @return $this
     */
    public function updateEntity(User $requestData, User $entity)
    {
        $created = $this->getEntityClass();

        foreach ($entity as $propertyName => $property) {
            if (\is_array($propertyName)) {
                $this->handleObject($property, $created);
            } else {
                $created[] = $this->handleProperty($property, $created);
            }

            $processedValue = $this->propertyAccessor->getValue($created, $propertyName);
            $this->propertyAccessor->setValue($entity, $propertyName, $processedValue);
            $errors = $this->validator->validateProperty($entity, $propertyName);
            if (\count($errors) > 0) {
                $this->addErrors($errors);
            }
        }

    }

    /**
     * @param array  $property
     * @param object $created
     *
     * @return $this
     */
    public function handleObject(array $property, object $created)
    {

    }

    /**
     * @param mixed  $property
     * @param object $created
     *
     * @return $this
     */
    public function handleProperty($property, object $created)
    {

    }

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return UserManager
     */
    public function addErrors(ConstraintViolationListInterface $errors): self
    {
        $this->errors->addAll($errors);

        return $this;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}