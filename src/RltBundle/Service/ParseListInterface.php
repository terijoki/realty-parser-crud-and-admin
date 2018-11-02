<?php

namespace RltBundle\Service;

/**
 * Interface ParseListInterface.
 *
 * @Annotation
 */
interface ParseListInterface
{
    /**
     * @return array
     */
    public function parseLinks(): array;

    /**
     * @param string $link
     *
     * @return string
     */
    public function getItem(string $link): string;
}
