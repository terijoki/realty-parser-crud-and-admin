<?php

namespace RltBundle\Command;

class RealtyNewParserCommand extends AbstractParserCommand
{
    protected const NAME = '';

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function process(): void
    {
        $links = $this->service->parseLinks();
        $dto = $this->parser->parseItem('a', 1);
        $entity = $this->validator->createEntity($dto, 1);
        die;

        foreach ($links as $id => $link) {
            if ($this->isUnique($id) && !$this->input->getOption('force')) {
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
