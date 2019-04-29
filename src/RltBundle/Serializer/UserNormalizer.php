<?php

namespace RltBundle\Serializer;

use RltBundle\Entity\Group;
use RltBundle\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * User normalizer.
 */
class UserNormalizer implements NormalizerInterface
{
    /**
     * @param User  $object
     * @param null  $format
     * @param array $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'username' => $object->getUsername(),
            'email' => $object->getEmail(),
            'groups' => \array_map(function (Group $item) {
                return [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                ];
            }, $object->getGroups()->toArray()),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof User;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return true;
    }
}
