<?php

namespace RltBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorsNormalizer implements NormalizerInterface
{
    const FORM = 'form';

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @param string                           $format
     * @param array                            $context
     *
     * @return array
     */
    public function normalize($constraintViolationList, $format = null, array $context = [])
    {
        $errors = [];

        foreach ($constraintViolationList as $violation) {
            if (!isset($errors[$violation->getPropertyPath()])) {
                $errors[$violation->getPropertyPath()] = [$violation->getMessage()];
            } else {
                $prevErrors = $errors[$violation->getPropertyPath()];
                $errors[$violation->getPropertyPath()] = \array_merge($prevErrors, [$violation->getMessage()]);
            }
        }

        if (self::FORM === $format) {
            foreach ($errors as $key => $error) {
                $errors[$key] = [
                    'errors' => $error,
                ];
            }
            $errors = [
                'children' => $errors,
            ];
        }

        return $errors;
    }

    /**
     * @param mixed  $data
     * @param string $format
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}
