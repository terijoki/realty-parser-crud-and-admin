<?php

namespace RltBundle\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

final class FlatSortType extends JsonType
{
    public const NAME = 'flats_sorted';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param AbstractPlatform $platform
     * @param mixed            $value
     *
     * @return null|string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return \json_encode([]);
        }

        if (\is_array($value)) {
            \sort($value);
        }

        return \json_encode($value);
    }
}
