<?php

namespace RltBundle\Command;

class RealtyUpdateParserCommand extends AbstractParserCommand
{
    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function process(): void
    {
        $buildingDTO = $this->parser->parseItem('a', 1);
        $building = $this->validator->createEntity($buildingDTO, 1);
        die;

        $links = $this->service->parseLinks();

        foreach ($links as $id => $link) {
            if ($this->isUnique($id)) {
                $item = $this->service->getItem($link);
                $dto = $this->parser->parseItem($item, $id);
                $entity = $this->validator->createEntity($dto, $id);
                $this->em->persist($entity);
            }
        }
    }

    /**
     * @param string $externalId
     *
     * @return bool
     */
    protected function isUnique(string $externalId): bool
    {
        return !\in_array($externalId, $this->storedIds, true);
    }
}
