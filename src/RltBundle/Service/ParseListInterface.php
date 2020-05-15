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
     * @param string $selector
     *
     * @return array
     */
    public function parseLinks(string $selector): array;

    /**
     * @param string $link
     *
     * @return string
     */
    public function getItem(string $link): string;
}
